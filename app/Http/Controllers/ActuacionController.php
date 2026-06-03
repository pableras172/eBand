<?php

namespace App\Http\Controllers;

use App\Models\Actuacion;
use App\Models\Contratos;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\Tipoactuacion;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OneSignal;
use Symfony\Component\HttpFoundation\Response;

class ActuacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actuaciones = Actuacion::with('contrato', 'lista', 'tipoactuacion')
            ->whereDate('fechaActuacion', '>=', now()->toDateString())
            ->where('visible', 1)
            ->orderBy('fechaActuacion', 'asc') // Ordenar por fechaActuacion ascendente
            ->get();

        $tiposActuacion = $actuaciones->pluck('tipoactuacion')->unique();
        $poblaciones = $actuaciones->pluck('contrato.poblacion')->unique();

        $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
            return Carbon::parse($actuacion->fechaActuacion)->format('m/Y');
        });

        return view('actuaciones.view-listas', compact('actuacionesPorMes', 'tiposActuacion', 'poblaciones'));
    }

    public function ubicacionesContratos()
    {
        // comprobar usuario logueado
        abort_if(! auth()->check(), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hoy = now()->startOfDay();
        $limite = now()->addMonths(6);

        $query = Actuacion::with('contrato', 'tipoactuacion')
            ->whereBetween('fechaActuacion', [$hoy, $limite])
            ->whereHas('contrato', function ($q) {
                $q->whereNotNull('latitude')
                    ->whereNotNull('longitude');
            })
            ->whereIn('id', function ($sub) use ($hoy, $limite) {
                $sub->selectRaw('MIN(id)')
                    ->from('actuacions as a2')
                    ->whereColumn('a2.contratos_id', 'actuacions.contratos_id')
                    ->whereBetween('a2.fechaActuacion', [$hoy, $limite]);
            });
        $actuaciones = $query->get();

        return response()->json(
            $actuaciones->map(fn ($a) => [
                'nombre' => $a->contrato->poblacion,
                'coords' => [
                    (float) $a->contrato->latitude,
                    (float) $a->contrato->longitude,
                ],
                'texto' => sprintf(
                    '<div class="text-sm">
                        <a href="%s" class="text-indigo-600 hover:underline">
                            <strong>%s</strong><br>
                            %s<br>
                            <span class="text-gray-600">%s · %s</span>
                        </a>
                    </div>',
                    route('listas.actuacion', ['actuacion_id' => $a->id]),
                    e(Carbon::parse($a->fechaActuacion)->format('d/m/Y')),
                    e($a->descripcion),
                    e(optional($a->tipoactuacion)->nombre),
                    e($a->contrato->poblacion)
                ),

            ])
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createtocontract(Request $request, $contratosId)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return redirect()->route('contratos.actuaciones.index', ['contrato' => $contratosId]);
    }

    /**
     * Crea una nova actuacio asociada al contrat
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            // Validar los datos de entrada
            $request->validate([
                'fechaActuacion' => 'required|date',
                'descripcion' => 'required|string',
                'tipoactuacions_id' => 'required|exists:tipoactuacions,id',
                'coches' => 'nullable|integer',
                'preciocoche' => 'nullable|numeric',
                'musicos' => 'nullable|integer',
                'preciomusico' => 'nullable|numeric',
                'totalcoches' => 'nullable|integer',
                'totalmusicos' => 'nullable|integer',
                'totalactuacion' => 'nullable|numeric',
                'contratos_id' => 'required|exists:contratos,id',
                'observaciones' => 'nullable|string',
                'is_draft' => 'nullable|boolean',
            ]);

            // Crear un nuevo objeto Actuacion
            $actuacion = new Actuacion;

            // Asignar los valores del request al objeto Actuacion
            $actuacion->fechaActuacion = $request->fechaActuacion;
            $actuacion->descripcion = $request->descripcion;
            $actuacion->tipoactuacions_id = $request->tipoactuacions_id;
            $actuacion->coches = $request->coches;
            $actuacion->preciocoche = $request->preciocoche;
            $actuacion->musicos = $request->musicos;
            $actuacion->preciomusico = $request->preciomusico;
            $actuacion->totalcoches = $request->totalcoches;
            $actuacion->totalmusicos = $request->totalmusicos;
            $actuacion->totalactuacion = $request->totalactuacion;
            $actuacion->contratos_id = $request->contratos_id;
            $actuacion->pagado = $request->pagado;
            $actuacion->aplicaporcentaje = $request->aplicaporcentaje;
            $actuacion->noaplicapago = $request->noaplicapago;
            $actuacion->observaciones = $request->observaciones;
            $actuacion->porcentajepersonal = $request->porcentajepersonal;
            $actuacion->visible = $request->visible ?? true; // Establecer el valor predeterminado de visible en true
            $actuacion->oficial = $request->oficial ?? true; // Establecer el valor predeterminado de oficial en true
            $actuacion->is_draft = $request->is_draft ?? false; // Establecer el valor predeterminado de is_draft en false
            // Guardar la actuación en la base de datos
            $actuacion->save();

            $actuacion->calendar = $this->generateICSFile($actuacion);
            $actuacion->update();

            // Obtener los datos necesarios para la vista
            $actuaciones = Actuacion::with('contrato', 'lista')
                ->where('contratos_id', '=', $request->contratos_id)
                ->orderBy('fechaActuacion', 'asc')
                ->get();

            $contrato = Contratos::find($request->contratos_id);
            $tipoActuacion = Tipoactuacion::all();

            // Retornar la vista con mensaje de éxito
            return view('livewire.contratos.actuacions', [
                'actuaciones' => $actuaciones,
                'tipoActuacion' => $tipoActuacion,
                'contrato' => $contrato,
                'message' => 'Actuación guardada con éxito.',
            ]);
        } catch (Exception $e) {
            // Manejar cualquier excepción
            return view('livewire.contratos.actuacions', [
                'message' => 'Ha ocurrido un error al guardar la actuación: '.$e->getMessage(),
            ]);
        }
    }

    public function notificarActuacion(Request $request)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Validar los datos de entrada
        $request->validate([
            'id' => 'required|integer',
        ]);

        try {
            $actuacion = Actuacion::with('contrato')->findOrFail($request->id);

            // Verifica si se encontró la actuación
            if (! $actuacion) {
                $notification = [
                    'message' => Lang::get('messages.no_actuations_found'),
                    'alert_type' => 'error',
                ];

                return response()->json($notification, 200);
            }

            // Formatear la fecha
            $fechaFormateada = Carbon::parse($actuacion->fechaActuacion)->format('d-m-Y');

            // Enviar notificación OneSignal
            OneSignal::sendNotificationToSegment(
                Lang::get('messages.new_actuacion_title', [
                    'fecha' => $fechaFormateada,
                    'descripcion' => $actuacion->descripcion,
                ]),
                'Active Subscriptions',
                env('APP_URL').'/listas/actuacion/'.$request->id,
                null,
                null,
                null,
                Lang::get('messages.notification_subtitle', [
                    'banda' => config('app.banda'),
                    'poblacion' => $actuacion->contrato->poblacion,
                ]),
                Lang::get('messages.view_details')
            );

            $notification = [
                'message' => Lang::get('messages.notification_sent'),
                'alert_type' => 'success',
            ];

            return response()->json($notification, 200);
        } catch (Exception $e) {
            Log::error('Error enviando la notificación: ', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $notification = [
                'message' => Lang::get('messages.notification_fail'),
                'alert_type' => 'error',
            ];

            return response()->json($notification, 500);
        }
    }

    public function notificarActuacionLista(Request $request)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Validar los datos de entrada
        $request->validate([
            'id' => 'required|integer',
        ]);

        try {
            $lista = Listas::with('actuacion')->findOrFail($request->id);
            $actuaciones = $lista->actuacion;

            // Verificar si se encontraron actuaciones
            if (! $actuaciones) {
                $notification = [
                    'message' => Lang::get('messages.no_actuations_found'),
                    'alert_type' => 'warning',
                ];

                return response()->json($notification, 404);
            }

            // Formatear la fecha
            $fechaFormateada = Carbon::parse($actuaciones->fechaActuacion)->format('d-m-Y');

            $asistentes = ListasUser::where('listas_id', $request->id)
                ->where('disponible', 1)
                ->get();

            // Verificar si se encontraron músicos
            if ($asistentes->isEmpty()) {
                $notification = [
                    'message' => Lang::get('messages.no_musicians_found'),
                    'alert_type' => 'warning',
                ];

                return response()->json($notification, 200);
            }

            foreach ($asistentes as $asistente) {
                $dest = User::where('id', $asistente->user_id)->first();
                if (! $dest || ! $dest->uuid) {
                    continue;
                }

                $message = Lang::get('messages.new_actuacion_notification', [
                    'fecha' => $fechaFormateada,
                    'poblacion' => $actuaciones->contrato->poblacion,
                ]);

                if ($asistente->coche) {
                    $message = Lang::get('messages.new_actuacion_notification_with_car', [
                        'poblacion' => $actuaciones->contrato->poblacion,
                    ]);
                }

                OneSignal::sendNotificationToExternalUser(
                    Lang::get('messages.new_actuacion_title', [
                        'fecha' => $fechaFormateada,
                        'descripcion' => $actuaciones->descripcion,
                    ]),
                    $dest->uuid,
                    env('APP_URL').'/listas/actuacion/'.$actuaciones->id,
                    null,
                    null,
                    null,
                    $message,
                    Lang::get('messages.view_details')
                );
            }
            $notification = [
                'message' => Lang::get('messages.notification_sent'),
                'alert_type' => 'success',
            ];

            return response()->json($notification, 200);
        } catch (Exception $e) {
            Log::error('Error enviando la notificación: ', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $notification = [
                'message' => Lang::get('messages.notification_fail'),
                'alert_type' => 'error',
            ];

            return response()->json($notification, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Actuacion $actuacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actuacion $actuacion)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return redirect()->route('contratos.actuaciones.index', [
            'contrato' => $actuacion->contratos_id,
            'edit' => $actuacion->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actuacion $actuacion)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // Validar los datos de entrada
        $request->validate([
            'fechaActuacion' => 'required|date',
            'descripcion' => 'required|string',
            'tipoactuacions_id' => 'required|exists:tipoactuacions,id',
            'coches' => 'nullable|integer',
            'preciocoche' => 'nullable|numeric',
            'musicos' => 'nullable|integer',
            'preciomusico' => 'nullable|numeric',
            'totalcoches' => 'nullable|integer',
            'totalmusicos' => 'nullable|integer',
            'totalactuacion' => 'nullable|numeric',
            'contratos_id' => 'required|exists:contratos,id',
            'observaciones' => 'nullable|string',
            'is_draft' => 'nullable|boolean',
        ]);

        // Asignar los valores del request al objeto Actuacion
        $actuacion->fechaActuacion = $request->fechaActuacion;
        $actuacion->descripcion = $request->descripcion;
        $actuacion->tipoactuacions_id = $request->tipoactuacions_id;
        $actuacion->coches = $request->coches;
        $actuacion->preciocoche = $request->preciocoche;
        $actuacion->musicos = $request->musicos;
        $actuacion->preciomusico = $request->preciomusico;
        $actuacion->totalcoches = $request->totalcoches;
        $actuacion->totalmusicos = $request->totalmusicos;
        $actuacion->totalactuacion = $request->totalactuacion;
        $actuacion->contratos_id = $request->contratos_id;
        $actuacion->pagado = $request->pagado;
        $actuacion->aplicaporcentaje = $request->aplicaporcentaje;
        $actuacion->noaplicapago = $request->noaplicapago;
        $actuacion->observaciones = $request->observaciones;
        $actuacion->porcentajepersonal = $request->porcentajepersonal;
        $actuacion->visible = $request->visible ?? true;
        $actuacion->oficial = $request->oficial ?? true;
        $actuacion->is_draft = $request->is_draft ?? false;

        $actuacion->calendar = $this->generateICSFile($actuacion);

        // Guardar la actuación en la base de datos
        $actuacion->update();

        // Redireccionar a una página o devolver una respuesta JSON según tus necesidades
        $actuaciones = Actuacion::with('contrato', 'lista')
            ->where('contratos_id', '=', $request->contratos_id)
            ->get();

        $contrato = Contratos::find($request->contratos_id);
        $tipoActuacion = Tipoactuacion::all();

        return view('livewire.contratos.actuacions', compact('actuaciones', 'tipoActuacion', 'contrato', 'actuacion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actuacion $actuacion)
    {

        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $actuacion->contratos_id;

        try {
            // Verificar si la actuación existe
            if ($actuacion) {
                $actuacion->delete();
            }
        } catch (QueryException $exception) {
            // Manejar la excepción de integridad referencial
            return redirect()
                ->route('contratos.actuaciones.index', ['contrato' => $cid])
                ->with('error', 'No puedes eliminar esta actuación porque tiene listas relacionadas');
        }

        return redirect()
            ->route('contratos.actuaciones.index', ['contrato' => $cid])
            ->with('deletesuccess', __('Actuación eliminada correctamente.'));
    }

    public function getTotalActuacionesUsuario(User $user, $year = null)
    {
        if ($user->id != Auth::user()->id) {
            abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        // Obtener el año actual si no se proporciona uno
        if ($year === null) {
            $year = Carbon::now()->year;
        }

        // Obtener todas las listas del usuario con sus respectivas actuaciones y tipos de actuación
        $listasConActuaciones = $user->listas()
            ->with('actuacion.tipoactuacion')
            ->whereHas('actuacion', function ($query) use ($year) {
                $query->whereYear('fechaActuacion', $year);
            })
            // ->where('disponible','<>','0')
            ->get();

        // dd($listasConActuaciones);
        // Inicializar un array para almacenar los totales por tipo de actuación junto con sus iconos
        $totalesPorTipoActuacion = [];

        // Iterar sobre cada lista y sumar al total correspondiente en base al tipo de actuación
        foreach ($listasConActuaciones as $lista) {
            $actuacion = $lista->actuacion;
            if ($actuacion) {
                $tipoActuacion = $actuacion->tipoactuacion;
                $tipoActuacionNombre = $tipoActuacion->nombre;
                $tipoActuacionIcono = $tipoActuacion->icon;
                $tipoActuacId = $tipoActuacion->id;

                if (! isset($totalesPorTipoActuacion[$tipoActuacionNombre])) {
                    $totalesPorTipoActuacion[$tipoActuacionNombre] = [
                        'total' => 0,
                        'icono' => $tipoActuacionIcono,
                        'tipoactuacion_id' => $tipoActuacId,
                    ];
                }
                $totalesPorTipoActuacion[$tipoActuacionNombre]['total']++;
            }
        }

        // Ahora $totalesPorTipoActuacion contiene los totales por tipo de actuación junto con sus iconos
        // Puedes pasar esto a la vista para mostrarlos
        return view('actuaciones.resumen-usuario', [
            'totalesPorTipoActuacion' => $totalesPorTipoActuacion,
            'year' => $year, // Pasamos el año a la vista para mostrarlo
            'usuario' => $user,
        ]);
    }

    /**
     * Obtiene las actuaciones de un usuario por año y poblacion
     */
    public function getActuacionesUsuarioPorPoblacionAnyo(User $user, $year, $poblacion)
    {
        // Validar que $year sea un año válido
        if (! is_numeric($year) || strlen($year) != 4 || $year < 2000 || $year > 2100) {
            Log::warning('Invalid year parameter in getActuacionesUsuarioPorPoblacionAnyo', [
                'year' => $year,
                'user_id' => $user->id,
                'poblacion' => $poblacion,
                'route' => request()->path(),
            ]);
            $year = date('Y'); // Usar año actual por defecto
        }

        $actuaciones = $user->listas()
            ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
            ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
            ->join('contratos', 'actuacions.contratos_id', '=', 'contratos.id')
            ->select('listas.*', 'actuacions.*', 'tipoactuacions.id AS tipoactuacion_id', 'tipoactuacions.nombre AS tipoactuacion_nombre', 'contratos.poblacion')
            ->whereYear('actuacions.fechaActuacion', $year) // Filtro por año actual
            ->where('contratos.poblacion', $poblacion)
            ->orderBy('actuacions.fechaActuacion', 'asc') // Ordenar por fechaActuacion ascendente
            ->get();

        $tiposActuacion = $actuaciones->pluck('tipoactuacion_nombre', 'tipoactuacion_id')->unique();
        $poblaciones = $actuaciones->pluck('poblacion')->unique();
        $filtropobla = true;

        $sql = '
        select
        tipoactuacions.nombre AS tipo,
        COUNT(*) as total
        from
        `listas`
        inner join `listas_user` on `listas`.`id` = `listas_user`.`listas_id`
        inner join `actuacions` on `listas`.`actuacions_id` = `actuacions`.`id`
        inner join `tipoactuacions` on `actuacions`.`tipoactuacions_id` = `tipoactuacions`.`id`
        inner join `contratos` on `actuacions`.`contratos_id` = `contratos`.`id`
        where
        `listas_user`.`user_id` ='.$user->id.'  
        and year(`actuacions`.`fechaActuacion`) ='.$year.' 
        and `contratos`.`poblacion` = "'.$poblacion.'"  
        and  `listas_user`.`disponible` = 1
        group by
        `tipoactuacions`.`nombre`
        order by
        `total` desc';

        $actuacionesGrph = DB::select($sql);

        if (! empty($actuacionesGrph)) {
            $labels = collect($actuacionesGrph)->pluck('tipo')->toArray();
            $data = collect($actuacionesGrph)->pluck('total')->toArray();
        } else {
            $labels = ['Sin datos']; // Etiqueta predeterminada
            $data = [0]; // Valor predeterminado para la gráfica
        }

        return view('actuaciones.listado-actuaciones-tipo-usuario', compact('actuaciones', 'year', 'user', 'tiposActuacion', 'poblaciones', 'filtropobla', 'labels', 'data'));
    }

    /**
     * listado de actuaciones de un usuario por año y tipo
     */
    public function getListadoActuacionesUsuarioAndTipo(User $user, $year, $type)
    {
        $auth = Auth::user();

        if ($user->id !== $auth->id && ! $auth->hijos->contains('id', $user->id)) {
            abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        // Validar que $year sea un año válido
        if (! is_numeric($year) || strlen($year) != 4 || $year < 2000 || $year > 2100) {
            Log::warning('Invalid year parameter in getListadoActuacionesUsuarioAndTipo', [
                'year' => $year,
                'user_id' => $user->id,
                'type' => $type,
                'route' => request()->path(),
            ]);
            $year = date('Y'); // Usar año actual por defecto
        }

        $actuaciones = $user->listas()
            ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
            ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
            ->join('contratos', 'actuacions.contratos_id', '=', 'contratos.id')
            ->select('listas.*', 'actuacions.*', 'tipoactuacions.id AS tipoactuacion_id', 'tipoactuacions.nombre AS tipoactuacion_nombre', 'contratos.poblacion')
            ->whereYear('actuacions.fechaActuacion', $year) // Filtro por año actual
            ->where('tipoactuacions.id', $type)
            ->orderBy('actuacions.fechaActuacion', 'asc') // Ordenar por fechaActuacion ascendente
            ->get();

        $tiposActuacion = $actuaciones->pluck('tipoactuacion_nombre', 'tipoactuacion_id')->unique();
        $poblaciones = $actuaciones->pluck('poblacion')->unique();

        $filtrotipo = true;

        $sql = '
        select
        tipoactuacions.nombre AS tipo,
        COUNT(*) as total
        from
        `listas`
        inner join `listas_user` on `listas`.`id` = `listas_user`.`listas_id`
        inner join `actuacions` on `listas`.`actuacions_id` = `actuacions`.`id`
        inner join `tipoactuacions` on `actuacions`.`tipoactuacions_id` = `tipoactuacions`.`id`
        inner join `contratos` on `actuacions`.`contratos_id` = `contratos`.`id`
        where
        `listas_user`.`user_id` ='.$user->id.'    
        and year(`actuacions`.`fechaActuacion`) ='.$year.'         
        and tipoactuacions_id = '.$type.'   
        group by 
        `tipoactuacions`.`nombre` 
        order by
        `total` desc';

        $actuacionesGrph = DB::select($sql);

        if (! empty($actuacionesGrph)) {
            $labels = collect($actuacionesGrph)->pluck('tipo')->toArray();
            $data = collect($actuacionesGrph)->pluck('total')->toArray();
        } else {
            $labels = ['Sin datos']; // Etiqueta predeterminada
            $data = [0]; // Valor predeterminado para la gráfica
        }

        // Puedes pasar $actuaciones a la vista para mostrar el listado
        return view('actuaciones.listado-actuaciones-tipo-usuario', compact('actuaciones', 'year', 'user', 'tiposActuacion', 'poblaciones', 'filtrotipo', 'labels', 'data'));
    }

    public function getListadoActuacionesUsuarioAndPoblacion(User $user, $year, $poblacion)
    {
        $auth = Auth::user();

        if ($user->id !== $auth->id && ! $auth->hijos->contains('id', $user->id)) {
            abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        // Validar que $year sea un año válido
        if (! is_numeric($year) || strlen($year) != 4 || $year < 2000 || $year > 2100) {
            Log::warning('Invalid year parameter in getListadoActuacionesUsuarioAndPoblacion', [
                'year' => $year,
                'user_id' => $user->id,
                'poblacion' => $poblacion,
                'route' => request()->path(),
            ]);
            $year = date('Y'); // Usar año actual por defecto
        }

        // Obtener actuaciones por población y fecha de actuación
        $actuaciones = Actuacion::with(['contrato', 'lista', 'tipoactuacion'])
            ->whereHas('contrato', function ($query) use ($poblacion) {
                $query->where('poblacion', $poblacion);
            })
            ->whereYear('fechaActuacion', $year)
            ->orderBy('fechaActuacion', 'asc')
            ->get();

        // Obtener tipos de actuación únicos
        $tiposActuacion = $actuaciones->pluck('tipoactuacion')->unique();

        // Obtener poblaciones únicas de los contratos relacionados
        $poblaciones = $actuaciones->pluck('contrato.poblacion')->unique();

        // Agrupar actuaciones por mes
        $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
            return Carbon::parse($actuacion->fechaActuacion)->format('m/Y');
        });

        $sql = '
        select
        tipoactuacions.nombre AS tipo,
        COUNT(*) as total
        from
        `listas`
        inner join `listas_user` on `listas`.`id` = `listas_user`.`listas_id`
        inner join `actuacions` on `listas`.`actuacions_id` = `actuacions`.`id`
        inner join `tipoactuacions` on `actuacions`.`tipoactuacions_id` = `tipoactuacions`.`id`
        inner join `contratos` on `actuacions`.`contratos_id` = `contratos`.`id`
        where
        `listas_user`.`user_id` ='.$user->id.'  
        and year(`actuacions`.`fechaActuacion`) ='.$year.' 
        and `contratos`.`poblacion` = '.$poblacion.'  
        group by
        `tipoactuacions`.`nombre`
        order by
        `total` desc';

        $actuacionesGrph = DB::select($sql);

        if (! empty($actuacionesGrph)) {
            $labels = collect($actuacionesGrph)->pluck('tipo')->toArray();
            $data = collect($actuacionesGrph)->pluck('total')->toArray();
        } else {
            $labels = ['Sin datos']; // Etiqueta predeterminada
            $data = [0]; // Valor predeterminado para la gráfica
        }

        // Indicador de filtro de población
        $filtropobla = true;

        return view('actuaciones.view-listas', compact('actuacionesPorMes', 'tiposActuacion', 'meses', 'filtropobla', 'poblaciones', 'user', 'labels', 'data'));
    }

    /**
     * Listado de actuacions filtradas por usuario y año
     */
    public function getListadoActuacionesUsuarioAnyo(User $user, $year)
    {

        $auth = Auth::user();

        if ($user->id !== $auth->id && ! $auth->hijos->contains('id', $user->id)) {
            abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        // Validar que $year sea un año válido
        if (! is_numeric($year) || strlen($year) != 4 || $year < 2000 || $year > 2100) {
            Log::warning('Invalid year parameter in getListadoActuacionesUsuarioAnyoTipo', [
                'year' => $year,
                'user_id' => $user->id,
                'route' => request()->path(),
            ]);
            $year = date('Y'); // Usar año actual por defecto
        }

        $actuaciones = $user->listas()
            ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
            ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
            ->join('contratos', 'actuacions.contratos_id', '=', 'contratos.id')
            ->select('listas.*', 'actuacions.*', 'tipoactuacions.id AS tipoactuacion_id', 'tipoactuacions.nombre AS tipoactuacion_nombre', 'contratos.poblacion')
            ->whereYear('actuacions.fechaActuacion', $year) // Filtro por año actual
            ->orderBy('actuacions.fechaActuacion', 'asc') // Ordenar por fechaActuacion ascendente
            ->get();

        $tiposActuacion = $actuaciones->pluck('tipoactuacion_nombre', 'tipoactuacion_id')->unique();
        $poblaciones = $actuaciones->pluck('poblacion')->unique();

        /*$actuacionesGrph = $user->listas()
        ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
        ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
        ->selectRaw('tipoactuacions.nombre AS tipo, COUNT(*) as total')
        ->whereYear('actuacions.fechaActuacion', $year)
        ->groupBy('tipoactuacions.nombre', 'tipoactuacions.id')
        ->orderBy('total', 'desc')
        ->get();*/

        $sql = '
                select
                tipoactuacions.nombre AS tipo,
                tipoactuacions.icon AS icono,
                COUNT(*) as total
                from
                `listas`
                inner join `listas_user` on `listas`.`id` = `listas_user`.`listas_id`
                inner join `actuacions` on `listas`.`actuacions_id` = `actuacions`.`id`
                inner join `tipoactuacions` on `actuacions`.`tipoactuacions_id` = `tipoactuacions`.`id`
                where
                `listas_user`.`user_id` ='.$user->id.'  
                and year(`actuacions`.`fechaActuacion`) ='.$year.' 
                group by
                `tipoactuacions`.`nombre`,
                `tipoactuacions`.`icon`
                order by
                `total` desc';

        $actuacionesGrph = DB::select($sql);

        if (! empty($actuacionesGrph)) {
            $labels = collect($actuacionesGrph)->pluck('tipo')->toArray();
            $data = collect($actuacionesGrph)->pluck('total')->toArray();
            $iconos = collect($actuacionesGrph)->pluck('icono')->toArray();
        } else {
            $labels = ['Sin datos']; // Etiqueta predeterminada
            $data = [0]; // Valor predeterminado para la gráfica
            $iconos = [null]; // Sin icono por defecto
        }

        // Puedes pasar $actuaciones a la vista para mostrar el listado
        return view('actuaciones.listado-actuaciones-tipo-usuario', compact('actuaciones', 'year', 'user', 'tiposActuacion', 'poblaciones', 'labels', 'data', 'iconos'));
    }

    public function generateICSFile($evento)
    {
        // Contenido del archivo .ics
        $content = "BEGIN:VCALENDAR\r\n";
        $content .= "VERSION:2.0\r\n";
        $content .= "PRODID:-//eBand\r\n";
        $content .= "BEGIN:VEVENT\r\n";
        $content .= 'UID:'.uniqid()."\r\n"; // Generar un ID único para el evento
        $content .= 'DTSTAMP;VALUE=DATE-TIME:'.Carbon::now()->format('Ymd\THis')."\r\n"; // Fecha y hora actual
        $content .= 'DTSTART;VALUE=DATE-TIME:'.Carbon::parse($evento->fechaActuacion)->format('Ymd\THis')."\r\n"; // Fecha y hora de inicio del evento
        $content .= 'DTEND;VALUE=DATE-TIME:'.Carbon::parse($evento->fechaActuacion)->format('Ymd\THis')."\r\n"; // Fecha y hora de fin del evento
        $content .= 'SUMMARY:'.Config::get('app.banda', 'eBand').' - '.$evento->descripcion."\r\n";
        $content .= 'DESCRIPTION:'.$evento->observaciones.' - '.Config::get('app.url').'/actuacion/'.$evento->id." \r\n";
        // $content .= "LOCATION:Calle Gandía, 21, 46892, Montaverner\r\n";
        // $content .= "GEO:38.8891800060307;-0.495599999999996\r\n";
        $content .= "END:VEVENT\r\n";
        $content .= "END:VCALENDAR\r\n";

        $newFileName = 'event_'.time().'.ics';
        Storage::put('eventos/'.$newFileName, $content);

        return $newFileName;
    }

    public function descargarCalendario(Request $request, $actuacionId)
    {
        $actuacion = Actuacion::find($actuacionId);

        if (! $actuacion) {
            abort(404); // Actuación no encontrada
        }

        return Storage::download('eventos/'.$actuacion->calendar);
    }

    /**
     * Filtra las actuaciones por tipo en el calendario principal
     */
    public function getActuacionesPorTipo(Request $request, $tipoActuiacionId)
    {

        $actuaciones = Actuacion::with('contrato', 'lista', 'tipoactuacion')
            ->whereDate('fechaActuacion', '>=', now()->toDateString())
            ->where('tipoactuacions_id', $tipoActuiacionId)
            ->orderBy('fechaActuacion', 'asc') // Ordenar por fechaActuacion ascendente
            ->get();

        // Obtener tipos de actuación únicos
        $tiposActuacion = $actuaciones->pluck('tipoactuacion')->unique();
        $poblaciones = $actuaciones->pluck('contrato.poblacion')->unique();

        // Obtener meses únicos
        $meses = $actuaciones->pluck('fechaActuacion')->map(function ($date) {
            return Carbon::parse($date)->format('m/Y');
        })->unique();

        $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
            return Carbon::parse($actuacion->fechaActuacion)->format('m/Y');
        });

        $filtrotipo = true;

        return view('actuaciones.view-listas', compact('actuacionesPorMes', 'tiposActuacion', 'meses', 'filtrotipo', 'poblaciones'));
    }

    /**
     * Filtra las actuaciones por poblacion en el listado del calendario principal
     */
    public function getActuacionesPorPoblacion(Request $request, $poblacion)
    {
        // Obtener actuaciones por población y fecha de actuación
        $actuaciones = Actuacion::with(['contrato', 'lista', 'tipoactuacion'])
            ->whereHas('contrato', function ($query) use ($poblacion) {
                $query->where('poblacion', $poblacion);
            })
            ->whereDate('fechaActuacion', '>=', now()->toDateString())
            ->orderBy('fechaActuacion', 'asc')
            ->get();

        // Obtener tipos de actuación únicos
        $tiposActuacion = $actuaciones->pluck('tipoactuacion')->unique();

        // Obtener poblaciones únicas de los contratos relacionados
        $poblaciones = $actuaciones->pluck('contrato.poblacion')->unique();

        // Obtener meses únicos
        $meses = $actuaciones->pluck('fechaActuacion')->map(function ($date) {
            return Carbon::parse($date)->format('m');
        })->unique();

        // Agrupar actuaciones por mes
        $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
            return Carbon::parse($actuacion->fechaActuacion)->format('m/Y');
        });

        // Indicador de filtro de población
        $filtropobla = true;

        return view('actuaciones.view-listas', compact('actuacionesPorMes', 'tiposActuacion', 'meses', 'filtropobla', 'poblaciones'));
    }

    public function getListadoActuacionesUsuarioAnyoTipo(User $user, $year, $tipo)
    {

        if ($user->id != Auth::user()->id && ! Auth::user()->hijos->contains($user->id)) {
            abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        // Validar que $year sea un año válido
        if (! is_numeric($year) || strlen($year) != 4 || $year < 2000 || $year > 2100) {
            Log::warning('Invalid year parameter in getListadoActuacionesUsuarioAnyoTipo', [
                'year' => $year,
                'user_id' => $user->id,
                'tipo' => $tipo,
                'route' => request()->path(),
            ]);
            $year = date('Y'); // Usar año actual por defecto
        }

        // Determinar la columna a filtrar en función del tipo recibido
        $tipoColumna = ($tipo === 'ensayo') ? 'tipoensayo' : 'tipoconcierto';
        $tipoLabelUser = ($tipo === 'ensayo') ? __('Asistencia Ensayos') : __('Asistencia Conciertos');
        $tipoLabeTotales = ($tipo === 'ensayo') ? __('Total Ensayos') : __('Total Conciertos');

        // Primera consulta: Cuenta actuaciones por tipo para el usuario
        $query1 = DB::table('listas')
            ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
            ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
            ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
            ->where('listas_user.user_id', $user->id)
            ->where('listas_user.disponible', 1)
            ->where('actuacions.fechaActuacion', '<=', now()->toDateString())
            ->whereYear('actuacions.fechaActuacion', $year)
            ->where("tipoactuacions.$tipoColumna", true)
            ->groupBy('tipoactuacions.nombre')
            ->select(DB::raw("'".$tipoLabelUser."' AS tipo"), DB::raw('COUNT(*) as total_tipo'));

        // Segunda consulta: Cuenta total de actuaciones para ese tipo
        $query2 = DB::table('actuacions')
            ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
            ->where("tipoactuacions.$tipoColumna", true)
            ->whereYear('actuacions.fechaActuacion', $year)
            ->where('actuacions.fechaActuacion', '<=', now()->toDateString())
            ->select(DB::raw("'".$tipoLabeTotales."' AS tipo"), DB::raw('COUNT(*) as total_tipo'));

        // Unir ambas consultas con UNION
        $actuacionesGrph = $query1->union($query2)->orderByDesc('total_tipo')->get();

        // Calcular porcentajes y preparar datos para la gráfica
        if ($actuacionesGrph->isNotEmpty()) {
            $totalGeneral = $actuacionesGrph->where('tipo', $tipoLabeTotales)->pluck('total_tipo')->first() ?? 0;

            // Evitar división por 0
            if ($totalGeneral == 0) {
                $totalGeneral = 1;
            }

            $actuacionesGrph = $actuacionesGrph->map(function ($item) use ($totalGeneral) {
                $item->porcentaje = round(($item->total_tipo / $totalGeneral) * 100, 1);

                return $item;
            });

            $labels = $actuacionesGrph->pluck('tipo')->toArray();
            $data = $actuacionesGrph->pluck('total_tipo')->toArray();
            $percentages = $actuacionesGrph->pluck('porcentaje')->toArray();
        } else {
            $labels = [__('Sin datos')];
            $data = [0];
            $percentages = [0];
        }

        // Retornar los datos como JSON para la gráfica
        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'percentages' => $percentages,
        ]);
    }

    /**
     * Filtra las actuaciones por fecha en el calendario principal
     */
    public function getActuacionesPorFecha(Request $request)
    {
        $fecha = $request->input('fecha');

        // Validar que la fecha no sea nula y esté dentro del rango permitido
        if (! $fecha) {
            return redirect()->route('actuacion.index');
        }

        $fechaSeleccionada = Carbon::parse($fecha);
        $fechaMinima = now()->subMonths(3);
        $fechaMaxima = now();

        // Validar que la fecha esté en el rango permitido
        if ($fechaSeleccionada->lt($fechaMinima) || $fechaSeleccionada->gt($fechaMaxima)) {
            return redirect()->route('actuacion.index');
        }

        $actuaciones = Actuacion::with('contrato', 'lista', 'tipoactuacion')
            ->whereDate('fechaActuacion', '>=', $fecha)
            ->where('visible', 1)
            ->orderBy('fechaActuacion', 'asc')
            ->get();

        $tiposActuacion = $actuaciones->pluck('tipoactuacion')->unique();
        $poblaciones = $actuaciones->pluck('contrato.poblacion')->unique();

        $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
            return Carbon::parse($actuacion->fechaActuacion)->format('m/Y');
        });

        $filtroFecha = $fecha;

        return view('actuaciones.view-listas', compact('actuacionesPorMes', 'tiposActuacion', 'poblaciones', 'filtroFecha'));
    }

    public function getUserStats(Request $request)
    {
        $userId = $request->input('user_id');
        $year = $request->input('year');
        $tipoId = $request->input('tipo_id');

        $user = User::findOrFail($userId);

        // Determinar la fecha límite según el año
        $endDate = ($year == date('Y'))
            ? Carbon::now()
            : Carbon::createFromDate($year, 12, 31)->endOfDay();

        // Total de actuaciones del tipo seleccionado en el año
        $totalActuaciones = Actuacion::whereYear('fechaActuacion', $year)
            ->where('tipoactuacions_id', $tipoId)
            ->where('fechaActuacion', '<=', $endDate)
            ->count();

        // Actuaciones en las que el usuario participó
        $actuacionesUsuario = $user->listas()
            ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
            ->whereYear('actuacions.fechaActuacion', $year)
            ->where('actuacions.tipoactuacions_id', $tipoId)
            ->where('actuacions.fechaActuacion', '<=', $endDate)
            ->count();

        $porcentaje = $totalActuaciones > 0
            ? round(($actuacionesUsuario / $totalActuaciones) * 100, 2)
            : 0;

        return response()->json([
            'total' => $totalActuaciones,
            'usuario' => $actuacionesUsuario,
            'porcentaje' => $porcentaje,
        ]);
    }

    public function getStatsByTipoYear(Request $request): JsonResponse
    {
        $year = (int) $request->input('year', date('Y'));

        $availableYears = Actuacion::query()
            ->join('listas', 'actuacions.id', '=', 'listas.actuacions_id')
            ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
            ->join('users', 'listas_user.user_id', '=', 'users.id')
            ->where('users.activo', 1)
            ->where('users.forastero', 0)
            ->selectRaw('DISTINCT YEAR(actuacions.fechaActuacion) as year')
            ->orderByDesc('year')
            ->pluck('year')
            ->map(fn ($value) => (int) $value)
            ->values();

        if ($availableYears->isEmpty()) {
            $currentYear = (int) date('Y');
            $availableYears = collect([$currentYear, $currentYear - 1, $currentYear - 2]);
        }

        if (! $availableYears->contains($year)) {
            $year = (int) $availableYears->first();
        }

        $statsByTipo = Actuacion::query()
            ->join('listas', 'actuacions.id', '=', 'listas.actuacions_id')
            ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
            ->join('users', 'listas_user.user_id', '=', 'users.id')
            ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
            ->where('users.activo', 1)
            ->where('users.forastero', 0)
            ->whereYear('actuacions.fechaActuacion', $year)
            ->selectRaw('tipoactuacions.id, tipoactuacions.nombre, COUNT(DISTINCT actuacions.id) as total')
            ->groupBy('tipoactuacions.id', 'tipoactuacions.nombre')
            ->orderByDesc('total')
            ->get();

        $totalActuaciones = (int) $statsByTipo->sum('total');

        $tipos = $statsByTipo->map(function ($item) use ($totalActuaciones): array {
            $total = (int) $item->total;

            return [
                'id' => (int) $item->id,
                'name' => $item->nombre,
                'total' => $total,
                'percentage' => $totalActuaciones > 0 ? round(($total / $totalActuaciones) * 100, 1) : 0,
            ];
        })->values();

        return response()->json([
            'year' => $year,
            'years' => $availableYears,
            'total' => $totalActuaciones,
            'tipos' => $tipos,
        ]);
    }
}
