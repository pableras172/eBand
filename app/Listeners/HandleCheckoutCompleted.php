<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookReceived;
use App\Models\User;

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
        if ($event->payload['type'] !== 'checkout.session.completed') {
            return;
        }

        $session = $event->payload['data']['object'];

        // Solo pagos únicos (donaciones)
        if ($session['mode'] !== 'payment') {
            return;
        }

        $user = User::where('stripe_id', $session['customer'])->first();
        if (!$user) return;

        // Persistencia en MySQL
        $user->lifetime_access = true;
        $user->save();
    }
}
