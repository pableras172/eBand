<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Listas;
use App\Models\User;
use App\Models\Actuacion;
use Illuminate\Support\Facades\Auth;
use App\Models\ListasUser;
use DateTime;

class PDFController extends Controller
{
    public function generatePDF()
    {       
        // Obtener la actuación y la lista relacionada
        $actuacion = Actuacion::findOrFail(115);
        $lista = $actuacion->lista;

        // Obtener todos los usuarios
        $usuarios = User::where('activo', 1)->get();

        // Marcar los usuarios seleccionados y con coche
        foreach ($usuarios as $usuario) {
            $usuario->seleccionado = false; // Por defecto, no seleccionado
            $usuario->coche = false; // Por defecto, no marcado
           
            // Verificar si el usuario está en la lista
            if ($lista->users->contains($usuario->id)) {       

                $usuario->seleccionado = true;
                // Verificar si el usuario tiene marcado el campo coche en la lista
                if ($lista->users()->where('id', $usuario->id)->first()->pivot->coche) {
                    $usuario->coche = true;
                }
                
            }
        }

        $data = ['actuacion' => $actuacion,
                'lista'=>$lista,
                'usuarios'=>$usuarios,];

        $pdf = PDF::loadView('pdf.document', $data);
        return $pdf->download('document.pdf');
    }
}
