<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListasUser;
use App\Models\User;

class ListaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        // Obtener el número total de usuarios
        $numUsuarios = User::count();
        $listas = \DB::table('listas')->pluck('id')->toArray();
        // Crear al menos 10 listas
        for ($i = 1; $i <= 10; $i++) {
            // Crear una lista vacía para esta iteración
            $lista = [];

            // Generar al menos 15 usuarios aleatorios para esta lista
            for ($j = 0; $j < 15; $j++) {
                $usuarioId = rand(1, $numUsuarios); // Seleccionar un usuario aleatorio

                // Agregar el usuario a la lista actual
                $lista[] = [
                    'listas_id'    => $faker->randomElement($listas), // Asignar el ID de lista actual
                    'user_id'     => $usuarioId, // Asignar el ID del usuario aleatorio
                    'coche'       => rand(0, 1),
                    'pagada'      => rand(0, 1),
                    'cuentas'     => rand(0, 1),
                   // 'created_at'  => now(),
                   // 'updated_at'  => now(),
                ];
            }

            // Insertar los datos de lista en la base de datos
            ListasUser::insert($lista);
        }
    }
}
