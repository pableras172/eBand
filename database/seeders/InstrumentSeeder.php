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
        $intrument = [
            [
                'id'             => 1,
                'name'           => 'Trompeta',    
                'orden'           => 1,    
                
            ],
            [
                'id'             => 2,
                'name'           => 'Clarinet',               
                'orden'           => 2,               
            ],
        ];

        Instrument::insert($intrument);
    }
}

