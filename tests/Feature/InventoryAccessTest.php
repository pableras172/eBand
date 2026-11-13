<?php

namespace Tests\Feature;

use App\Livewire\Inventory\InventoryIndex;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InventoryAccessTest extends TestCase
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

    public function test_admin_can_view_all_inventory_items_and_admin_actions(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]); // Admin

        $category = InventoryCategory::factory()->create(['nombre' => 'Percussió']);
        InventoryItem::factory()->create([
            'nombre' => 'Caixa Pearl',
            'inventory_category_id' => $category->id,
            'year' => now()->year,
        ]);
        InventoryItem::factory()->create([
            'nombre' => 'Bombo Yamaha',
            'inventory_category_id' => $category->id,
            'year' => now()->year,
        ]);

        $this->actingAs($admin)
            ->get(route('inventory.index'))
            ->assertOk()
            ->assertSee('Caixa Pearl')
            ->assertSee('Bombo Yamaha')
            ->assertSee(__('Afegir nou material'))
            ->assertSee(__('Excel'))
            ->assertSee(__('PDF'))
            ->assertSee(__('Estadístiques'));
    }

    public function test_admin_can_delete_inventory_item(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $category = InventoryCategory::factory()->create();
        $item = InventoryItem::factory()->create([
            'nombre' => 'Material a eliminar',
            'inventory_category_id' => $category->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(InventoryIndex::class)
            ->call('confirmDelete', $item->id)
            ->assertSet('confirmingDeletion', true)
            ->assertSet('itemToDeleteId', $item->id)
            ->call('deleteItem')
            ->assertSet('confirmingDeletion', false);

        $this->assertDatabaseMissing('inventory_items', [
            'id' => $item->id,
        ]);
    }

    public function test_user_with_assigned_item_only_sees_their_own_item(): void
    {
        $this->ensureBaseRoles();

        $user = User::factory()->create(); // Role 2 (User)
        $otherUser = User::factory()->create();

        $category = InventoryCategory::factory()->create();
        $assignedItem = InventoryItem::factory()->create([
            'nombre' => 'Clarinet Buffet E11',
            'inventory_category_id' => $category->id,
            'year' => now()->year,
        ]);
        $assignedItem->responsables()->attach($user->id);

        $unassignedItem = InventoryItem::factory()->create([
            'nombre' => 'Saxòfon Alt Yamaha',
            'inventory_category_id' => $category->id,
            'year' => now()->year,
        ]);
        $unassignedItem->responsables()->attach($otherUser->id);

        $this->actingAs($user)
            ->get(route('inventory.index'))
            ->assertOk()
            ->assertSee('Clarinet Buffet E11')
            ->assertDontSee('Saxòfon Alt Yamaha')
            ->assertDontSee(__('Afegir nou material'))
            ->assertDontSee(__('Estadístiques'));
    }

    public function test_user_without_assigned_items_sees_empty_state_message(): void
    {
        $this->ensureBaseRoles();

        $user = User::factory()->create(); // Role 2 (User)

        $category = InventoryCategory::factory()->create();
        InventoryItem::factory()->create([
            'nombre' => 'Trompeta Bach',
            'inventory_category_id' => $category->id,
        ]);

        $this->actingAs($user)
            ->get(route('inventory.index'))
            ->assertOk()
            ->assertSee(__('No tens cap material assignat'))
            ->assertDontSee('Trompeta Bach');
    }

    public function test_user_cannot_view_unassigned_item_details(): void
    {
        $this->ensureBaseRoles();

        $user = User::factory()->create();

        $category = InventoryCategory::factory()->create();
        $unassignedItem = InventoryItem::factory()->create([
            'nombre' => 'Tuba Miraphone',
            'inventory_category_id' => $category->id,
        ]);

        $this->actingAs($user)
            ->get(route('inventory.show', $unassignedItem))
            ->assertForbidden();
    }

    public function test_user_can_view_assigned_item_details_without_economic_data(): void
    {
        $this->ensureBaseRoles();

        $user = User::factory()->create();

        $category = InventoryCategory::factory()->create(['nombre' => 'Vent Fusta']);
        $assignedItem = InventoryItem::factory()->create([
            'nombre' => 'Flauta Yamaha 211',
            'inventory_category_id' => $category->id,
            'valor_unitario' => 650.00,
        ]);
        $assignedItem->responsables()->attach($user->id);

        $this->actingAs($user)
            ->get(route('inventory.show', $assignedItem))
            ->assertOk()
            ->assertSee('Flauta Yamaha 211')
            ->assertSee('Vent Fusta')
            ->assertDontSee(__('Dades econòmiques (Administració)'))
            ->assertDontSee(__('Eliminar'));
    }
}
