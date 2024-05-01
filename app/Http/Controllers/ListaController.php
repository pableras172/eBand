<?php

namespace App\Http\Controllers;

use App\Models\Listas;
use App\Models\User;
use App\Models\Actuacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ListasUser;
use DateTime;
class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        
    }    

    public function actuacion($actuacionId)
    {
        // Obtener la actuación y la lista relacionada
        $actuacion = Actuacion::findOrFail($actuacionId);
        $lista = $actuacion->lista;

        if ($lista == null) {
            $lista = new Listas();
            $lista->actuacions_id = $actuacionId;            
            $lista->pagada = 0;            
            $lista->cuentas = 0;            
            $lista->save(); // Guardar la nueva lista en la base de datos
        }

        $usuarioDisponible = true;

        if ($lista->users->contains(Auth::user()->id)
            && !$lista->users()->where('id', (Auth::user()->id))->first()->pivot->disponible) {
                $usuarioDisponible = false;
        }

        // Obtener todos los usuarios
        $usuarios = User::where('activo', 1)->get();

        // Marcar los usuarios seleccionados y con coche
        foreach ($usuarios as $usuario) {
            $usuario->seleccionado = false; // Por defecto, no seleccionado
            $usuario->coche = false; // Por defecto, no marcado
            $usuario->disponible = true;
            // Verificar si el usuario está en la lista
            if ($lista->users->contains($usuario->id)) {
                if (!$lista->users()->where('id', $usuario->id)->first()->pivot->disponible) {
                    $usuario->disponible = false;
                    continue;
                }
                $usuario->seleccionado = true;
                // Verificar si el usuario tiene marcado el campo coche en la lista
                if ($lista->users()->where('id', $usuario->id)->first()->pivot->coche) {
                    $usuario->coche = true;
                }
                
            }
        }

        // Contar el número total de filas en ListasUser con el lista_id dado
        $totalFilas = ListasUser::where('listas_id', $lista->id)->where('disponible','<>','0')->count();

        // Contar el número de elementos con el campo "coche" igual a 1
        $cochesCount = ListasUser::where('listas_id', $lista->id)->where('coche', 1)->count();

        //Comprobamos las fechas para no dejar comunicar el no disponible si son menos de 2 dias

        $date1 = new DateTime($actuacion->fechaActuacion);
        $date2 = new DateTime(); // Fecha actual
        
        $antelacion = $date1->diff($date2);

        return view('actuaciones.detalles-actuacion', compact('actuacion', 'usuarios','lista','usuarioDisponible','totalFilas','cochesCount','antelacion'));
    }
    


 
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lista $lista)
    {
        return view('actuaciones.detalles-actuacion');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lista $lista)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lista $lista)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lista $lista)
    {
        //
    }
}
