<?php

namespace Database\Factories;

use App\Models\Actuacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Actuacion>
 */
class ActuacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fechaActuacion' => $this->faker->dateTime(),
            'descripcion' => $this->faker->sentence(),
            'coches' => $this->faker->numberBetween(0, 5),
            'preciocoche' => $this->faker->randomFloat(2, 30, 100),
            'musicos' => $this->faker->numberBetween(5, 50),
            'preciomusico' => $this->faker->randomFloat(2, 20, 80),
            'totalcoches' => $this->faker->randomFloat(2, 100, 500),
            'totalmusicos' => $this->faker->randomFloat(2, 100, 500),
            'totalactuacion' => $this->faker->randomFloat(2, 200, 1000),
            'pagado' => $this->faker->boolean(),
            'aplicaporcentaje' => true,
            'noaplicapago' => false,
            'observaciones' => $this->faker->paragraph(),
            'porcentajepersonal' => null,
            'visible' => true,
            'oficial' => true,
            'is_draft' => false,
        ];
    }
}
