<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exports\ActividadInscritosExport;
use App\Models\Actividad;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ActividadExportController extends Controller
{
    public function export(Actividad $actividad): BinaryFileResponse
    {
        abort_if(! Gate::allows('admin'), 403, 'No autorizado para exportar actividades.');

        $slug = Str::slug($actividad->titulo);
        $fechaStr = $actividad->fecha ? $actividad->fecha->format('Ymd') : date('Ymd');
        $filename = "actividad_{$slug}_{$fechaStr}.xlsx";

        return Excel::download(new ActividadInscritosExport($actividad), $filename);
    }
}
