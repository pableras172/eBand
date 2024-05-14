<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Actuacion;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function generatePDF($actuacionId)
    {       
        // Obtener la actuación y la lista relacionada
        $actuacion = Actuacion::findOrFail($actuacionId);
        $lista = $actuacion->lista;

        // Obtener todos los usuarios de la lista donde disponible = 1
        $usuarios = $lista->users()
            ->wherePivot('disponible', true)
            ->with('instrument')
            ->orderBy('instrument_id')
            ->orderBy('name')
            ->get();

        $data = [
            'actuacion' => $actuacion,
            'lista' => $lista,
            'usuarios' => $usuarios,
        ];

        $pdf = PDF::loadView('pdf.document', $data);
        return $pdf->download('document.pdf');
    }
}
