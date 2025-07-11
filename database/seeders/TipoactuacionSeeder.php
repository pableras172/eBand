<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Tipoactuacion;

class TipoactuacionSeeder extends Seeder
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
                      [               
                'nombre' => 'Parcial'
            ],
            [               
                'nombre' => 'Entrada Mora'
            ],
            [               
                'nombre' => 'Entrada Cristiana'
            ],
            [               
                'nombre' => 'Reunio'
            ],
        ];

        Tipoactuacion::insert($t);
    }
}
