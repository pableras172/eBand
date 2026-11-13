<?php

namespace App\Http\Controllers;

use App\Helpers\ConfigHelper;
use App\Mail\UserNoDisponible;
use App\Models\Configuration;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

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
        $listaUser = new ListasUser;
        $listaUser->listas_id = $request->lista_id;
        $listaUser->user_id = $request->usuario_id;

        // Guardar el registro en la base de datos
        $listaUser->save();

        // Contar el número total de filas en ListasUser con el lista_id dado
        $totalFilas = ListasUser::where('listas_id', $request->lista_id)->where('disponible', '<>', '0')->count();

        // Contar el número de elementos con el campo "coche" igual a 1
        $cochesCount = ListasUser::where('listas_id', $request->lista_id)->where('coche', 1)->count();

        // Devolver una respuesta adecuada con los datos solicitados
        return response()->json([
            'message' => 'Relación lista-usuario creada correctamente',
            'total_filas' => $totalFilas,
            'coches_count' => $cochesCount,
        ], 201);
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

        $campo = 'coche';
        // Ver que campo actualizamos: coche o furgo
        if ($request->furgo) {
            $campo = 'furgona';
        }

        // Actualizar el campo "coche" en la tabla ListasUser
        $updated = ListasUser::where('listas_id', $request->lista_id)
            ->where('user_id', $request->usuario_id)
            ->update([$campo => $request->estado]);

        // Contar el número total de filas en ListasUser con el lista_id dado
        $totalFilas = ListasUser::where('listas_id', $request->lista_id)->where('disponible', '<>', '0')->count();

        // Contar el número de elementos con el campo "coche" igual a 1
        $cochesCount = ListasUser::where('listas_id', $request->lista_id)->where('coche', 1)->count();
        $cochesCount = $cochesCount + ListasUser::where('listas_id', $request->lista_id)->where('furgona', 1)->count();

        if ($updated) {
            // Devolver una respuesta adecuada
            return response()->json(['message' => 'Campo '.$campo.' actualizado correctamente',
                'total_filas' => $totalFilas,
                'coches_count' => $cochesCount], 200);
        } else {
            // Devolver una respuesta indicando que la relación no fue encontrada
            return response()->json(['message' => 'Relación lista-usuario no encontrada'], 404);
        }
    }

    public function setdisponible(Request $request)
    {
        // Validar los datos recibidos en la solicitud
        $request->validate([
            'lista_id' => 'nullable|exists:listas,id',
            'actuacion_id' => 'nullable|exists:actuacions,id',
            'usuario_id' => 'required|exists:users,id',
            'estado' => 'nullable|string|in:duda,no,disponible,si',
            'disponible' => 'nullable',
            'duda' => 'nullable',
        ]);

        $listaId = $request->lista_id;
        if (! $listaId && $request->actuacion_id) {
            $lista = Listas::firstOrCreate(
                ['actuacions_id' => $request->actuacion_id],
                ['pagada' => 0, 'cuentas' => 0]
            );
            $listaId = $lista->id;
        }

        if (! $listaId) {
            return response()->json(['message' => 'No se pudo identificar la lista de la actuación'], 422);
        }

        $lista = Listas::with('actuacion')->findOrFail($listaId);
        $actuacion = $lista->actuacion;
        $currentUser = auth()->user();
        $isAdmin = $currentUser && $currentUser->roles()->where('title', 'Admin')->exists();

        // 1. Validar límite de antelación para no-administradores
        if ($actuacion && ! $isAdmin) {
            $limiteAntelacion = (int) (ConfigHelper::getConfigValue('diasantelacion') ?? 5);
            $diasRestantes = now()->startOfDay()->diffInDays(Carbon::parse($actuacion->fechaActuacion)->startOfDay(), false);

            if ($diasRestantes <= $limiteAntelacion) {
                return response()->json([
                    'message' => __('No es pot canviar la disponibilitat amb menys de :dias dies d\'antelació. Contacta amb la direcció.', ['dias' => $limiteAntelacion]),
                    'alert_type' => 'error',
                ], 422);
            }
        }

        $hasDudaColumn = Schema::hasColumn('listas_user', 'duda');

        $existingRelation = ListasUser::where('listas_id', $listaId)
            ->where('user_id', $request->usuario_id)
            ->first();

        // Determinar el nuevo estado solicitado
        $estadoSolicitado = $request->input('estado');
        if (! $estadoSolicitado) {
            if ($request->boolean('duda')) {
                $estadoSolicitado = 'duda';
            } elseif ($request->has('disponible')) {
                $estadoSolicitado = ((int) $request->disponible === 0) ? 'no' : 'disponible';
            } else {
                $estadoSolicitado = 'disponible';
            }
        }

        // 2. Si el usuario ya está convocado/confirmado por dirección en la lista, no puede ponerse en duda ni en no asistir
        if ($existingRelation && ! $isAdmin) {
            $yaConvocado = ((int) $existingRelation->disponible === 1 && empty($existingRelation->duda));
            if ($yaConvocado && in_array($estadoSolicitado, ['duda', 'no'], true)) {
                return response()->json([
                    'message' => __('Has sigut convocat per la direcció. No pots marcar que no assisteixes o que tens dubtes. Contacta amb un administrador.'),
                    'alert_type' => 'error',
                ], 422);
            }
        }

        $nuevoEstado = 'disponible';

        if ($existingRelation) {
            $actualDisponible = (int) $existingRelation->disponible;
            $actualDuda = $hasDudaColumn ? (bool) $existingRelation->duda : false;

            if ($estadoSolicitado === 'duda') {
                // Toggle: si ya estaba en duda, vuelve a disponible
                if ($actualDuda) {
                    $nuevoEstado = 'disponible';
                    $existingRelation->update(array_filter([
                        'disponible' => 1,
                        'duda' => $hasDudaColumn ? false : null,
                    ], fn ($v) => $v !== null));
                } else {
                    $nuevoEstado = 'duda';
                    $existingRelation->update(array_filter([
                        'disponible' => 1,
                        'duda' => $hasDudaColumn ? true : null,
                    ], fn ($v) => $v !== null));
                }
            } elseif ($estadoSolicitado === 'no') {
                // Toggle: si ya estaba en 'no', vuelve a disponible
                if ($actualDisponible === 0) {
                    $nuevoEstado = 'disponible';
                    $existingRelation->update(array_filter([
                        'disponible' => 1,
                        'duda' => $hasDudaColumn ? false : null,
                    ], fn ($v) => $v !== null));
                } else {
                    $nuevoEstado = 'no';
                    $existingRelation->update(array_filter([
                        'disponible' => 0,
                        'duda' => $hasDudaColumn ? false : null,
                    ], fn ($v) => $v !== null));
                }
            } else {
                // Restablecer a disponible
                $nuevoEstado = 'disponible';
                $existingRelation->update(array_filter([
                    'disponible' => 1,
                    'duda' => $hasDudaColumn ? false : null,
                ], fn ($v) => $v !== null));
            }
        } else {
            $nuevoEstado = match ($estadoSolicitado) {
                'duda' => 'duda',
                'no' => 'no',
                default => 'disponible',
            };

            $nuevoModel = new ListasUser;
            $nuevoModel->listas_id = $listaId;
            $nuevoModel->user_id = $request->usuario_id;
            $nuevoModel->disponible = ($nuevoEstado === 'no') ? 0 : 1;
            if ($hasDudaColumn) {
                $nuevoModel->duda = ($nuevoEstado === 'duda');
            }
            $nuevoModel->save();
        }

        $customText = match ($nuevoEstado) {
            'duda' => 'Dubte comunicat (pendent)',
            'no' => 'No disponible (Baixa comunicada)',
            default => 'Disponible / Convocat',
        };

        try {
            $lista = Listas::with('actuacion')->findOrFail($listaId);
            $actuacion = $lista->actuacion;
            $user = User::where('id', $request->usuario_id)->first();

            $mailadmin = Configuration::where('param', 'emaildisponibles')->first();

            if ($mailadmin != null && $mailadmin->value != '') {
                $emails = explode(';', $mailadmin->value);
                foreach ($emails as $email) {
                    Mail::to(trim($email))->send(new UserNoDisponible($user, $actuacion, $customText));
                }
            }

        } catch (Exception $e) {
            logger()->error('Error al enviar el correo: '.$e->getMessage());
        }

        $notification = [
            'message' => Lang::get('messages.disponibilidadactualizada'),
            'alert_type' => 'success',
            'nuevo_estado' => $nuevoEstado,
            'estado_label' => $customText,
            'lista_id' => $listaId,
        ];

        return response()->json($notification, 200);
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
            // $listaUser->delete();
            $lista->users()->detach($usuarioId);

            // Contar el número total de filas en ListasUser con el lista_id dado
            $totalFilas = ListasUser::where('listas_id', $listaId)->count();

            // Contar el número de elementos con el campo "coche" igual a 1
            $cochesCount = ListasUser::where('listas_id', $listaId)->where('coche', 1)->count();

            // Devolver una respuesta adecuada
            return response()->json(['message' => 'Relación lista-usuario eliminada correctamente',
                'total_filas' => $totalFilas,
                'coches_count' => $cochesCount], 200);
        } else {
            // Devolver una respuesta indicando que la relación no fue encontrada
            return response()->json(['message' => 'Relación lista-usuario no encontrada'], 404);
        }
    }

    public function clean($listaId)
    {
        if (ListasUser::where('listas_id', $listaId)->delete()) {

            $totalFilas = ListasUser::where('listas_id', $listaId)->count();

            // Contar el número de elementos con el campo "coche" igual a 1
            $cochesCount = ListasUser::where('listas_id', $listaId)->where('coche', 1)->count();

            // Devolver una respuesta adecuada
            return response()->json(['message' => 'Lista limpia',
                'total_filas' => $totalFilas,
                'coches_count' => $cochesCount], 200);
        }
    }
}
