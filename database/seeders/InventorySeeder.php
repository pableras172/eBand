<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use existing categories from database
        $categories = InventoryCategory::query()->get();

        if ($categories->isEmpty()) {
            return;
        }

        // Create 15 inventory items
        $items = InventoryItem::factory(15)
            ->recycle($categories)
            ->create();

        // Get some users to assign as responsibles
        $users = User::limit(3)->get();

        // Assign users to items and create movements
        foreach ($items as $item) {
            if ($users->count() > 0) {
                $randomUsers = $users->random(rand(1, min(2, $users->count())));
                $item->responsables()->attach($randomUsers->pluck('id')->toArray());
            }

            // Create initial movement record
            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'user_id' => $users->first()?->id ?? 1,
                'tipo' => 'compra',
                'descripcion' => 'Compra inicial del item de inventario',
            ]);
        }
    }
}
