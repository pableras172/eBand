<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Tipoactuacions;

class TipoactuacionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $t = [
            [               
                'nombre' => 'Ensayo'
            ],
            [               
                'nombre' => 'Pasacalle'
            ],
        ];

        Tipoactuacions::insert($t);
    }
}
