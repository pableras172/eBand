<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Actuacion;
use Carbon\Carbon;

class ActuacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define los datos para las actuaciones
        $actuaciones = [];
        $faker = \Faker\Factory::create();

        // Crea 10 actuaciones ficticias
        for ($i = 0; $i < 30; $i++) {
            $fechaActuacion = $faker->dateTimeBetween('-1 year', '+1 year');
            $actuaciones[] = [
                'fechaActuacion' => $fechaActuacion,
                'descripcion' => $faker->sentence(6),
                'tipoactuacions_id' => $faker->numberBetween(1, 8), // Suponiendo que existen 3 tipos de actuaciones en la tabla "tipo_actuaciones"
                'coches' => $faker->numberBetween(0, 10),
                'preciocoche' => $faker->randomFloat(2, 10, 100),
                'musicos' => $faker->numberBetween(1, 20),
                'preciomusico' => $faker->randomFloat(2, 50, 200),
                'totalcoches' => $faker->numberBetween(0, 10),
                'totalmusicos' => $faker->numberBetween(1, 20),
                'totalactuacion' => $faker->randomFloat(2, 500, 2000),
                'contratos_id' => 7,
                'pagado' => $faker->boolean(),
                'observaciones' => $faker->text(100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Inserta los datos en la base de datos
     Actuacion::insert($actuaciones);
    }
}
