<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookReceived;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class HandleCheckoutCompleted
{
    /**
     * Create the event listener.
     */
    /*public function __construct()
    {
        //
    }*/

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event)
    {
        Log::info('[Webhook] Received event', [
            'type' => $event->payload['type'] ?? null,
        ]);

        if (($event->payload['type'] ?? null) !== 'checkout.session.completed') {
            Log::info('[Webhook] Ignored: not checkout.session.completed');
            return;
        }

        $session = $event->payload['data']['object'] ?? [];
        Log::info('[Webhook] checkout.session.completed payload', [
            'mode' => $session['mode'] ?? null,
            'customer' => $session['customer'] ?? null,
            'id' => $session['id'] ?? null,
        ]);

        if (($session['mode'] ?? null) !== 'payment') {
            Log::info('[Webhook] Ignored: mode is not payment', ['mode' => $session['mode'] ?? null]);
            return;
        }

        $customerId = $session['customer'] ?? null;
        if (!$customerId) {
            Log::warning('[Webhook] Missing customer in session');
            return;
        }

        Log::info('[Webhook] Looking up user by stripe_id', ['customer' => $customerId]);
        $user = User::where('stripe_id', $customerId)->first();

        if (!$user) {
            Log::warning('[Webhook] No user found for stripe_id', ['customer' => $customerId]);
            return;
        }

        Log::info('[Webhook] Granting lifetime_access', ['user_id' => $user->id]);
        $user->lifetime_access = true;
        $user->save();
        Log::info('[Webhook] lifetime_access saved', ['user_id' => $user->id, 'lifetime_access' => $user->lifetime_access]);
    }
}
