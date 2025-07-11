<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Listas;

class ListaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Define los datos para las listas
       $listas = [];
        $faker = \Faker\Factory::create();
       // Suponiendo que tienes 10 actuaciones y 10 usuarios
       $numActuaciones = 10;
       $actuacions = \DB::table('actuacions')->pluck('id')->toArray(); // o Contrato::pluck('id')->toArray();

       // Crea 10 registros de lista ficticios asociados a una actuación y un usuario aleatorio
       for ($i = 1; $i <= $numActuaciones; $i++) {
          
               $listas[] = [
                   'actuacions_id' => $faker->randomElement($actuacions), // Asigna una actuación aleatoria
                   //'users_id' => rand(1,2), // Asigna un usuario aleatorio
                   //'coche' => rand(0, 1),
                   'pagada' => rand(0, 1),
                   'cuentas' => rand(0, 1),
                   'created_at' => now(),
                   'updated_at' => now(),
               ];
          
       }

       // Inserta los datos en la base de datos
       Listas::insert($listas);
    }
}
