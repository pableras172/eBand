<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Configuration;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfigurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Configuration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'param' => fake()->word(),
            'value' => fake()->word(),
        ];
    }
}
