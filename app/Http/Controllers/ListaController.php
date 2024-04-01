<?php

namespace App\Http\Controllers;

use App\Models\Listas;
use App\Models\User;
use App\Models\Actuacion;
use Illuminate\Http\Request;

class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        
    }

    /*public function actuacion($request)
    {
        // Obtener el actuacion_id de la solicitud
        $actuacion_id = $request;
    
        // Obtener la actuación y cargar las relaciones 'actuacion' y 'users'
        $listas = Lista::where('actuacions_id', $actuacion_id)
            ->with(['actuacion', 'users.instrument']) // Cargar la relación 'instrument' dentro de 'users'
            ->get();
    
        // Ordenar los usuarios por el campo 'orden' de 'instruments'
        $listas->each(function ($lista) {
            $lista->users = $lista->users->sortBy('instrument.orden');
        });
    
        return view('actuaciones.detalles-actuacion', compact('listas'));
    }*/

/*public function actuacion($request)
    {
        // Obtener el id de la actuación de la solicitud
        $actuacion_id = $request;
    
        // Obtener la actuación y cargar las relaciones 'actuacion' y 'users' con el campo 'coche' de la tabla pivot
        $listas = Lista::where('actuacions_id', $actuacion_id)
            ->with(['actuacion', 'users' => function ($query) {
                $query->select('users.*', 'lista_user.coche'); // Seleccionar el campo 'coche' de la tabla pivot
            }])
            ->get();
    
        // Obtener todos los usuarios
        $usuarios = User::all();
    
        // Marcamos los usuarios que están en la lista y obtenemos la información del coche
        $listas->each(function ($lista) use ($usuarios) {
            $usuarios->each(function ($usuario) use ($lista) {
                // Marcar si el usuario está en la lista
                $usuario->selected = $lista->users->contains('id', $usuario->id);
    
                // Obtener la información del coche para este usuario desde la relación 'users'
                $usuario->coche = $usuario->pivot->coche ?? false;
            });
        });
    
        return view('actuaciones.detalles-actuacion', compact('listas', 'usuarios'));
    }*/

    public function actuacion($actuacionId)
    {
        // Obtener la actuación y la lista relacionada
        $actuacion = Actuacion::findOrFail($actuacionId);
        $lista = $actuacion->listas->first();

        if ($lista == null) {
            $lista = new Listas();
            $lista->actuacions_id = $actuacionId;            
            $lista->pagada = 0;            
            $lista->cuentas = 0;            
            $lista->save(); // Guardar la nueva lista en la base de datos
        }

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

        return view('actuaciones.detalles-actuacion', compact('actuacion', 'usuarios','lista'));
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
