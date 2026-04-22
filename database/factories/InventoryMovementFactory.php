<?php

namespace Database\Factories;

use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryMovement>
 */
class InventoryMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inventory_item_id' => InventoryItem::factory(),
            'user_id' => User::factory(),
            'tipo' => $this->faker->randomElement(['compra', 'reparacion', 'asignacion', 'baja', 'actualizacion']),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
