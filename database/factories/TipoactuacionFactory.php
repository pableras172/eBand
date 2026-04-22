<?php

namespace Database\Factories;

use App\Models\Tipoactuacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tipoactuacion>
 */
class TipoactuacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->randomElement(['Concierto', 'Ensayo', 'Actuación']),
        ];
    }
}
