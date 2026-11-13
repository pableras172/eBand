<?php

namespace Tests\Feature;

use App\Models\Instrument;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstrumentManagementTest extends TestCase
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

    public function test_admin_can_view_instruments_index_without_broken_footer(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $response = $this->actingAs($admin)->get(route('instrument.index'));

        $response->assertOk()
            ->assertSee(__('Nou instrument'))
            ->assertDontSee('id="🎨-Color"');
    }

    public function test_admin_can_view_create_form_and_store_instrument(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $nextOrder = (Instrument::max('orden') ?? 0) + 1;

        $this->actingAs($admin)
            ->get(route('instrument.create'))
            ->assertOk()
            ->assertSee(__('Dades de l\'instrument'));

        $response = $this->actingAs($admin)->post(route('instrument.store'), [
            'name' => 'Fagot Schreiber',
            'orden' => $nextOrder,
        ]);

        $response->assertRedirect(route('instrument.index'));

        $this->assertDatabaseHas('instruments', [
            'name' => 'Fagot Schreiber',
            'orden' => $nextOrder,
        ]);
    }

    public function test_admin_can_view_edit_form_with_related_musicians(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $instrument = Instrument::first();

        $musician1 = User::factory()->create(['name' => 'Joan Martínez', 'instrument_id' => $instrument->id, 'activo' => true]);
        $musician2 = User::factory()->create(['name' => 'Marta Doménech', 'instrument_id' => $instrument->id, 'activo' => false]);

        $response = $this->actingAs($admin)->get(route('instrument.show', $instrument));

        $response->assertOk()
            ->assertSee($instrument->name)
            ->assertSee('Joan Martínez')
            ->assertSee('Marta Doménech')
            ->assertSee(__('Músics de la corda'))
            ->assertSee('2');
    }

    public function test_admin_can_update_and_delete_instrument(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $instrument = Instrument::first();
        $musician = User::factory()->create(['name' => 'Carles', 'instrument_id' => $instrument->id]);

        $newOrder = (Instrument::max('orden') ?? 0) + 5;

        // Update
        $this->actingAs($admin)->put(route('instrument.update', $instrument), [
            'name' => 'Instrument Renombrat',
            'orden' => $newOrder,
        ])->assertRedirect(route('instrument.index'));

        $this->assertDatabaseHas('instruments', [
            'id' => $instrument->id,
            'name' => 'Instrument Renombrat',
            'orden' => $newOrder,
        ]);

        // Delete
        $this->actingAs($admin)->delete(route('instrument.destroy', $instrument))
            ->assertRedirect(route('instrument.index', ['success' => true]));

        $this->assertDatabaseMissing('instruments', [
            'id' => $instrument->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $musician->id,
            'instrument_id' => null,
        ]);
    }
}
