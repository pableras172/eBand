<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\BandSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecaptchaProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_recaptcha_for_contact_and_demo(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('class="g-recaptcha', false);
        $response->assertSee('https://www.google.com/recaptcha/api.js', false);
    }

    public function test_masinfo_page_renders_recaptcha(): void
    {
        BandSetting::query()->create([
            'nombre' => 'Banda de Prueba',
            'activarcontactoinfo' => true,
        ]);

        $response = $this->get('/masinfo');

        $response->assertStatus(200);
        $response->assertSee('class="g-recaptcha', false);
        $response->assertSee('https://www.google.com/recaptcha/api.js', false);
    }
}
