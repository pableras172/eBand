<?php

namespace App\Livewire\Actuaciones;

use App\Models\Actuacion;
use App\Models\Contratos;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Imports\ActuacionesImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Tipoactuacion;

class ImportarExcel extends Component
{
    use WithFileUploads;
    public $errores = [];
    public $mensajeExito = null;

    public $contratoId;
    public $excel;

    public function rules()
    {
        return [
            'excel' => 'required|file|mimes:xlsx,xls'
        ];
    }

    public function importar()
    {
        $this->validate();

        $import = new ActuacionesImport();
        Excel::import($import, $this->excel);

        //dd($import);
        $this->errores = [];

        foreach ($import->datos as $index => $fila) {
            try {
                $coches = $fila['coches'] ?? 0;
                $preciocoche = $fila['preciocoche'] ?? 0;
                $musicos = $fila['musicos'] ?? 0;
                $preciomusico = $fila['preciomusico'] ?? 0;

                $excelFecha = $fila['fechaactuacion'] ?? null;
                $fechaActuacion = null;

                if (is_numeric($excelFecha)) {
                    $fechaActuacion = Date::excelToDateTimeObject($excelFecha)->format('Y-m-d');
                } elseif (!empty($excelFecha)) {
                    $fechaActuacion = \Carbon\Carbon::parse($excelFecha)->format('Y-m-d');
                } else {
                    throw new \Exception('Fecha no válida');
                }

                $tipoNombre = $fila['tipoactuacions_id'] ?? null;
                $tipoId = Tipoactuacion::where('nombre', $tipoNombre)->value('id') ?? 1;
                if (!$tipoNombre) {
                    $this->errores[] = "Fila " . ($index + 2) . ": tipoactuacion_nombre vacío. Se ha usado tipo ID 1.";
                }

                Actuacion::create([
                    'fechaActuacion'     => $fechaActuacion,
                    'descripcion'        => $fila['descripcion'] ?? throw new \Exception('Descripción obligatoria'),
                    'tipoactuacions_id'  => $tipoId,
                    'coches'             => $coches,
                    'preciocoche'        => $preciocoche,
                    'musicos'            => $musicos,
                    'preciomusico'       => $preciomusico,
                    'totalcoches'        => $coches * $preciocoche,
                    'totalmusicos'       => $musicos * $preciomusico,
                    'totalactuacion'     => $fila['totalactuacion'] ?? 0,
                    'contratos_id'       => $this->contratoId,
                    'pagado'             => $fila['pagado'] ?? false,
                    'aplicaporcentaje'   => $fila['aplicaporcentaje'] ?? false,
                    'noaplicapago'       => $fila['noaplicapago'] ?? false,
                    'observaciones'      => $fila['observaciones'] ?? null,
                    'porcentajepersonal' => $fila['porcentajepersonal'] ?? null,
                ]);
            } catch (\Exception $e) {
                $this->errores[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        if (empty($this->errores)) {
            $this->mensajeExito = 'Importación completada sin errores.';
        } else {
            $this->mensajeExito = 'Importación finalizada con ' . count($this->errores) . ' errores.';
        }

        $this->reset('excel');
    }



    public function render()
    {
        return view('livewire.actuaciones.importar-excel');
    }
}
