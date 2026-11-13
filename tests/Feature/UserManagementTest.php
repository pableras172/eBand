<?php

namespace Tests\Feature;

use App\Models\Instrument;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
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

    public function test_admin_can_view_edit_user_page_with_new_style_and_no_broken_footer(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $instrument = Instrument::first() ?? Instrument::forceCreate([
            'name' => 'Clarinet Sib',
            'orden' => 1,
        ]);

        $musician = User::factory()->create([
            'name' => 'Marta Domènech',
            'instrument_id' => $instrument->id,
            'porcentaje' => 100,
            'fechaAlta' => '2023-01-15',
            'activo' => 1,
            'forastero' => 0,
        ]);
        $musician->roles()->sync([2]);

        $response = $this->actingAs($admin)->get(route('users.edit', $musician->id));

        $response->assertOk()
            ->assertSee(__('Editar músic'))
            ->assertSee('Marta Domènech')
            ->assertSee(__('Identitat i accés'))
            ->assertSee(__('Dades musicals'))
            ->assertSee(__('Estat i perfil'))
            ->assertSee(__('Familia musical'))
            ->assertSee(__('Permisos'))
            ->assertSee(__('Actualitzar músic'))
            ->assertDontSee('id="🎨-Color"');
    }

    public function test_admin_can_view_create_user_page(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $response = $this->actingAs($admin)->get(route('users.create'));

        $response->assertOk()
            ->assertSee(__('Nou Music'))
            ->assertSee(__('Guardar músic'))
            ->assertDontSee('id="🎨-Color"');
    }

    public function test_regular_user_cannot_access_user_edit(): void
    {
        $this->ensureBaseRoles();

        $user = User::factory()->create();
        $user->roles()->sync([2]);

        $otherMusician = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users.edit', $otherMusician->id));

        $response->assertForbidden();
    }

    public function test_admin_can_update_musician(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $instrument = Instrument::first() ?? Instrument::forceCreate([
            'name' => 'Trompeta Do',
            'orden' => 2,
        ]);

        $musician = User::factory()->create([
            'name' => 'Joan Mas',
            'email' => 'joan@eband.test',
            'telefono' => '654987321',
            'instrument_id' => $instrument->id,
            'porcentaje' => 80,
            'fechaAlta' => '2022-09-01',
            'activo' => 1,
        ]);
        $musician->roles()->sync([2]);

        $response = $this->actingAs($admin)->put(route('users.update', $musician->id), [
            'name' => 'Joan Mas García',
            'email' => 'joan.actualizado@eband.test',
            'telefono' => '600111222',
            'fechaAlta' => '2022-09-01',
            'instrument_id' => $instrument->id,
            'porcentaje' => 90,
            'activo' => '1',
            'forastero' => '0',
            'tienefurgo' => '1',
            'tienecoche' => '0',
            'roles' => [2],
        ]);

        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $musician->id,
            'name' => 'Joan Mas García',
            'email' => 'joan.actualizado@eband.test',
            'telefono' => '600111222',
            'porcentaje' => 90,
            'tienefurgo' => 1,
        ]);
    }
}
