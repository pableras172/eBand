<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Actuacion;
use App\Models\Paymentresume;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            ->join('instruments', 'users.instrument_id', '=', 'instruments.id')
            ->orderBy('instruments.orden')
            ->orderBy('name')
            ->get();

        $data = [
            'actuacion' => $actuacion,
            'lista' => $lista,
            'usuarios' => $usuarios,
        ];

        $pdf = PDF::loadView('pdf.document', $data);

        $nombreDocumento = Str::slug($actuacion->descripcion) . '.pdf';
        return $pdf->download($nombreDocumento);
    }


    public function generatePaymentResumePDF(Paymentresume $paymentresume)
    {       
        // Obtener la actuación y la lista relacionada
        //$actuacion = Actuacion::findOrFail($actuacionId);
        //$lista = $actuacion->lista;

        $data = [
            'paymentresume' => $paymentresume,            
        ];

        $pdf = PDF::loadView('pdf.paymentresume', $data);

        $nombreDocumento = Str::slug($paymentresume->descripcion) . '.pdf';
        return $pdf->download($nombreDocumento);
    }
}
