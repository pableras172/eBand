<?php

namespace Tests\Feature;

use App\Mail\DemoInterestThankYou;
use App\Models\DemoAccessLead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DemoAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_lead_sends_email_and_logs_in_demo_user(): void
    {
        Mail::fake();

        $response = $this->post(route('demo.access'), [
            'nombre' => 'Ana',
            'apellidos' => 'Garcia',
            'email' => 'ana@example.com',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('demo_access_leads', [
            'nombre' => 'Ana',
            'apellidos' => 'Garcia',
            'email' => 'ana@example.com',
        ]);

        $lead = DemoAccessLead::query()->first();
        $this->assertNotNull($lead);

        $demoUser = User::query()->where('email', config('demo.user_email'))->first();
        $this->assertNotNull($demoUser);
        $this->assertAuthenticatedAs($demoUser);

        Mail::assertSent(DemoInterestThankYou::class, function (DemoInterestThankYou $mail): bool {
            return $mail->hasTo('ana@example.com');
        });
    }

    public function test_demo_user_cannot_perform_write_actions(): void
    {
        $demoUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $demoUser->roles()->sync([2]);

        $response = $this->actingAs($demoUser)
            ->withSession(['demo_mode' => true])
            ->post('/notificaciones/999/leer');

        $response->assertSessionHas('error');
    }
}
