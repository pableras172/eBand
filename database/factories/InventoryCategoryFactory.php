<?php

namespace Database\Factories;

use App\Models\InventoryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryCategory>
 */
class InventoryCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = ['Instrumentos', 'Atriles', 'Muebles', 'Equipamiento', 'Herramientas', 'Electrónica'];

        return [
            'nombre' => $this->faker->unique()->randomElement($categorias),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
