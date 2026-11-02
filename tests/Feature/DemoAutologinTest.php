<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Tests\TestCase;

class DemoAutologinTest extends TestCase
{
    use RefreshDatabase;

    public function test_autologin_with_valid_token_authenticates_user_and_redirects(): void
    {
        $user = User::factory()->create([
            'email' => 'probadordemo@example.com',
            'activo' => true,
        ]);

        $token = Str::random(64);
        Cache::put('demo_autologin_'.$token, [
            'email' => 'probadordemo@example.com',
            'lead_id' => 123,
        ], now()->addMinutes(15));

        $response = $this->get('/demo/autologin?token='.$token);

        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(session('demo_mode'));
        $this->assertSame(123, session('demo_lead_id'));
    }

    public function test_autologin_with_invalid_or_expired_token_redirects_to_login(): void
    {
        $response = $this->get('/demo/autologin?token=tokeninvalido');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_quick_login_authenticates_demo_admin(): void
    {
        $admin = User::query()->where('email', 'admin@eband.app')->first();

        if (! $admin) {
            $admin = User::factory()->create([
                'email' => 'admin@eband.app',
                'activo' => true,
            ]);
        }

        $response = $this->post('/demo/quick-login');

        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($admin);
        $this->assertTrue(session('demo_mode'));
    }
}
