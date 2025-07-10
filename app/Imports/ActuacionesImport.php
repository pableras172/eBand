<?php


namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ActuacionesImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    public $datos;

    public function collection(Collection $rows)
    {
        $this->datos = $rows;
    }

    public function sheets(): array
    {
        return [
            'Hoja1' => $this, // sustituye "Hoja1" por el nombre exacto de tu hoja
        ];
    }
}


