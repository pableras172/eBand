<?php

namespace Tests\Feature;

use App\Models\BandSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BandSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function ensureBaseRoles(): void
    {
        Role::query()->upsert([
            ['id' => 1, 'title' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'User', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'title' => 'SuperAdmin', 'created_at' => now(), 'updated_at' => now()],
        ], ['id'], ['title', 'updated_at']);
    }

    public function test_admin_can_view_band_settings_page_with_neo_bento_style(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        BandSetting::query()->create([
            'nombre' => 'Unió Musical d\'Alberic',
            'direccion' => 'Carrer Major, 12',
            'nif_cif' => 'G12345678',
            'telefono' => '600123456',
            'email' => 'info@banda.test',
            'website' => 'https://banda.test',
            'activarcontactoinfo' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('band-settings.edit'));

        $response->assertOk()
            ->assertSee(__('Dades de la banda'))
            ->assertSee('Unió Musical d\'Alberic')
            ->assertSee(__('Identitat de la banda'))
            ->assertSee(__('Xarxes socials'))
            ->assertSee(__('Presidència i imatge'))
            ->assertSee(__('Formulari públic de contacte'))
            ->assertSee(__('QR d\'accés a /masinfo'))
            ->assertSee(__('Desar dades de la banda'))
            ->assertDontSee('id="🎨-Color"');
    }

    public function test_regular_user_cannot_access_band_settings(): void
    {
        $this->ensureBaseRoles();

        $user = User::factory()->create();
        $user->roles()->sync([2]);

        $response = $this->actingAs($user)->get(route('band-settings.edit'));

        $response->assertForbidden();
    }

    public function test_admin_can_update_band_settings(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $response = $this->actingAs($admin)->put(route('band-settings.update'), [
            'nombre' => 'Societat Musical Nova',
            'direccion' => 'Avinguda de la Música, 5',
            'nif_cif' => 'G87654321',
            'telefono' => '654321987',
            'email' => 'nova@banda.test',
            'website' => 'https://novabanda.test',
            'urlinstagram' => 'https://instagram.com/novabanda',
            'urlfacebook' => 'https://facebook.com/novabanda',
            'urltiktok' => 'https://tiktok.com/@novabanda',
            'activarcontactoinfo' => '1',
        ]);

        $response->assertRedirect(route('band-settings.edit'))
            ->assertSessionHas('success_message');

        $this->assertDatabaseHas('band_settings', [
            'nombre' => 'Societat Musical Nova',
            'direccion' => 'Avinguda de la Música, 5',
            'nif_cif' => 'G87654321',
            'email' => 'nova@banda.test',
            'activarcontactoinfo' => 1,
        ]);
    }
}
