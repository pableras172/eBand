<?php

namespace Database\Factories;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inventory_category_id' => InventoryCategory::factory(),
            'year' => now()->year,
            'nombre' => $this->faker->word().' '.$this->faker->word(),
            'cantidad' => $this->faker->numberBetween(1, 50),
            'valor_unitario' => $this->faker->randomFloat(2, 10, 500),
            'estado' => $this->faker->randomElement(['nuevo', 'usado', 'desperfectos', 'dañado']),
            'observaciones' => $this->faker->paragraph(),
            'depreciation_rate' => $this->faker->randomElement([0, 5, 10, 15, 20]),
            'purchase_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
        ];
    }
}
