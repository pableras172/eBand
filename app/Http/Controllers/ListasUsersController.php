<?php

namespace App\Http\Controllers;

use App\Models\ListasUser;
use App\Models\Listas;
use Illuminate\Http\Request;

class ListasUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validar los datos recibidos en la solicitud
        $request->validate([
            'lista_id' => 'required|exists:listas,id',
            'usuario_id' => 'required|exists:users,id',
        ]);

        // Crear una nueva instancia de ListaUser con los datos recibidos
        $listaUser = new ListasUser();
        $listaUser->listas_id = $request->lista_id;
        $listaUser->user_id = $request->usuario_id;

        // Guardar el registro en la base de datos
        $listaUser->save();

        // Devolver una respuesta adecuada
        return response()->json(['message' => 'Relación lista-usuario creada correctamente'], 201);
    }

    /**
 * Store a newly created resource in storage.
 */
public function storecar(Request $request)
{
    // Validar los datos recibidos en la solicitud
    $request->validate([
        'lista_id' => 'required|exists:listas,id',
        'usuario_id' => 'required|exists:users,id',        
    ]);

    // Actualizar el campo "coche" en la tabla ListasUser
    $updated = ListasUser::where('listas_id', $request->lista_id)
                        ->where('user_id', $request->usuario_id)
                        ->update(['coche' => $request->estado]);

    if ($updated) {
        // Devolver una respuesta adecuada
        return response()->json(['message' => 'Campo "coche" actualizado correctamente'], 200);
    } else {
        // Devolver una respuesta indicando que la relación no fue encontrada
        return response()->json(['message' => 'Relación lista-usuario no encontrada'], 404);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(ListasUser $listaUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListasUser $listaUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListasUser $listaUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($listaId, $usuarioId)
    {
        // Buscar la relación lista-usuario por los IDs de la lista y el usuario
    /* $listaUser = ListasUser::where('listas_id', $listaId)
                            ->where('user_id', $usuarioId)
                            ->first();*/

        // Buscar la relación lista-usuario por los IDs de la lista y el usuario
        $lista = Listas::where('id', $listaId)->first();

        // Verificar si la relación lista-usuario existe
        if ($lista) {
            // Eliminar la relación lista-usuario
            //$listaUser->delete();
            $lista->users()->detach($usuarioId);
            // Devolver una respuesta adecuada
            return response()->json(['message' => 'Relación lista-usuario eliminada correctamente'], 200);
        } else {
            // Devolver una respuesta indicando que la relación no fue encontrada
            return response()->json(['message' => 'Relación lista-usuario no encontrada'], 404);
        }
    }
}
