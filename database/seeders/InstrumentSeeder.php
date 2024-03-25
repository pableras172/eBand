<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Instrument;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instruments = [
            ['name' => 'Flauta', 'orden' => 1],
            ['name' => 'Clarinete', 'orden' => 2],
            ['name' => 'Saxo Alto', 'orden' => 3],
            ['name' => 'Saxo Tenor', 'orden' => 4],
            ['name' => 'Trompeta', 'orden' => 5],
            ['name' => 'Trombón', 'orden' => 6],
            ['name' => 'Tuba', 'orden' => 7],
            ['name' => 'Percusión', 'orden' => 8],
            ['name' => 'Piano', 'orden' => 9],           
            // Agrega más instrumentos aquí si es necesario
        ];

        Instrument::insert($instruments);
    }
}

