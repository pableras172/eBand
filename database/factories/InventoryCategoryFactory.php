<?php

namespace Database\Factories;

use App\Models\InventoryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryCategory>
 */
class InventoryCategoryFactory extends Factory
{
    protected $model = InventoryCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = ['Instrumentos', 'Atriles', 'Muebles', 'Equipamiento', 'Herramientas', 'Electrónica'];

        return [
            'nombre' => fake()->unique()->randomElement($categorias),
            'descripcion' => fake()->sentence(),
        ];
    }
}
