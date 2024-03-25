<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contratos;

class ContratosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $contratos = [[
            'poblacion' => 'Ciudad A',
            'fechainicio' => '2023-01-01',
            'fechafin' => '2023-12-31',
            'descripcion' => 'Contrato de servicios en la Ciudad A',
            'contacto' => 'Juan Pérez',
            'telefono' => '123456789',
            'correo' => 'juan@example.com',
            'anyo' => 2023,
            'dnicontacto' => '12345678A',
            'observacions' => 'Este contrato incluye mantenimiento regular.'
        ],
        [
            'poblacion' => 'Ciudad B',
            'fechainicio' => '2023-02-15',
            'fechafin' => '2023-11-30',
            'descripcion' => 'Contrato de suministro en la Ciudad B',
            'contacto' => 'María Gómez',
            'telefono' => '987654321',
            'correo' => 'maria@example.com',
            'anyo' => 2023,
            'dnicontacto' => '87654321B',
            'observacions' => null
        ]];
        
        Contratos::insert($contratos);
    }
}
