<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Instrument;

class UsersTableSeeder extends Seeder
{
    /*public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'instrument_id' => 1,
            ],
            [
                'id'             => 2,
                'name'           => 'User',
                'email'          => 'user@user.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'instrument_id' => 2,
            ],
        ];

        User::insert($users);
    }*/

    public function run()
    {
        $instrumentos = Instrument::pluck('id')->toArray();

        $users = [];
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $users[] = [
                'name'           => $faker->firstName,
                'email'          => $faker->unique()->safeEmail,
                'password'       => Hash::make('password'), // Aquí se usa Hash::make para hashear la contraseña
                'remember_token' => Str::random(10),
                'instrument_id'  => $faker->randomElement($instrumentos),
            ];
        }

        User::insert($users);
    }
}
