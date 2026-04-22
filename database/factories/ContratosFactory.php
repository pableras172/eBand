<?php

namespace Database\Factories;

use App\Models\Contratos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contratos>
 */
class ContratosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descripcion' => $this->faker->sentence(),
            'poblacion' => $this->faker->city(),
            'contacto' => $this->faker->name(),
            'telefono' => $this->faker->phoneNumber(),
            'correo' => $this->faker->email(),
            'anyo' => $this->faker->year(),
            'fechainicio' => $this->faker->date(),
            'fechafin' => $this->faker->date(),
        ];
    }
}
