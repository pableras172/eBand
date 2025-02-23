<?php

namespace App\Http\Controllers;

use App\Models\Actuacion;
use App\Models\Contratos;
use App\Models\Tipoactuacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use OneSignal;
use App\Models\User;
use App\Models\Listas;
use App\Models\ListasUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Lang;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActuacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

     public function index()
     {        
         $actuaciones = Actuacion::with('contrato', 'lista','tipoactuacion')
             ->whereDate('fechaActuacion', '>=', now()->toDateString())
             ->orderBy('fechaActuacion', 'asc') // Ordenar por fechaActuacion ascendente
             ->get();
     
            $tiposActuacion = $actuaciones->pluck('tipoactuacion')->unique();
            $poblaciones = $actuaciones->pluck('contrato.poblacion')->unique();

         $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
             return Carbon::parse($actuacion->fechaActuacion)->format('m/Y');
         });
     
         return view('actuaciones.view-listas', compact('actuacionesPorMes','tiposActuacion', 'poblaciones'));
     }
     
    
    /**
     * Show the form for creating a new resource.
     */
    public function createtocontract(Request $request, $contratosId)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $actuaciones =  Actuacion::with('contrato','lista')
        ->where('contratos_id', '=', $contratosId)
        ->orderBy('fechaActuacion', 'asc')
        ->get();

        $tipoActuacion = Tipoactuacion::all();

        $contrato = Contratos::find( $contratosId);

        return view('livewire.contratos.actuacions',compact('actuaciones','tipoActuacion','contrato'));
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
             ]);
     
             // Crear un nuevo objeto Actuacion
             $actuacion = new Actuacion();
     
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
     
             // Guardar la actuación en la base de datos
             $actuacion->save();
     
             $actuacion->calendar = $this->generateICSFile($actuacion);
             $actuacion->update();
     
             // Obtener los datos necesarios para la vista
             $actuaciones = Actuacion::with('contrato','lista')
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
                 'message' => 'Actuación guardada con éxito.'
             ]);
         } catch (\Exception $e) {
             // Manejar cualquier excepción
             return view('livewire.contratos.actuacions', [
                 'message' => 'Ha ocurrido un error al guardar la actuación: ' . $e->getMessage(),
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
        if (!$actuacion) {
            $notification = array(
                'message' => Lang::get('messages.no_actuations_found'),
                'alert_type' => 'error'
            );
            return response()->json($notification, 200);           
        }

        // Formatear la fecha
        $fechaFormateada = Carbon::parse($actuacion->fechaActuacion)->format('d-m-Y');

        // Enviar notificación OneSignal
        OneSignal::sendNotificationToSegment(
            Lang::get('messages.new_actuacion_title', [
                'fecha' => $fechaFormateada,
                'descripcion' => $actuacion->descripcion
            ]),
            "Active Subscriptions", 
            env('APP_URL') . "/listas/actuacion/" . $request->id, 
            null, 
            null, 
            null, 
            Lang::get('messages.notification_subtitle', [
                'banda' => config('app.banda'),
                'poblacion' => $actuacion->contrato->poblacion
            ]), 
            Lang::get('messages.view_details')
        );

        $notification = array(
            'message' => Lang::get('messages.notification_sent'),
            'alert_type' => 'success'
        );
        return response()->json($notification, 200);                 
    } catch (\Exception $e) {   
        Log::error('Error enviando la notificación: ', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]); 
        $notification = array(
            'message' => Lang::get('messages.notification_fail'),
            'alert_type' => 'error'
        );
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
        if (!$actuaciones) {
            $notification = [
                'message' => Lang::get('messages.no_actuations_found'),
                'alert_type' => 'warning'
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
                'alert_type' => 'warning'
            ];
            return response()->json($notification, 200);
        }

        foreach ($asistentes as $asistente) {
            $dest = User::where('id', $asistente->user_id)->first();
            if (!$dest || !$dest->uuid) {
                continue;
            }

            $message = Lang::get('messages.new_actuacion_notification', [
                'fecha' => $fechaFormateada,
                'poblacion' => $actuaciones->contrato->poblacion
            ]);

            if ($asistente->coche) {
                $message = Lang::get('messages.new_actuacion_notification_with_car', [
                    'poblacion' => $actuaciones->contrato->poblacion
                ]);
            }

            OneSignal::sendNotificationToExternalUser(
                Lang::get('messages.new_actuacion_title', [
                    'fecha' => $fechaFormateada,
                    'descripcion' => $actuaciones->descripcion
                ]),
                $dest->uuid,
                env('APP_URL') . "/listas/actuacion/" . $actuaciones->id,
                null,
                null,
                null,
                $message,
                Lang::get('messages.view_details')
            );
        }
        $notification = [
            'message' => Lang::get('messages.notification_sent'),
            'alert_type' => 'success'
        ];
        return response()->json($notification, 200);
    } catch (\Exception $e) {
        Log::error('Error enviando la notificación: ', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        $notification = [
            'message' => Lang::get('messages.notification_fail'),
            'alert_type' => 'error'
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

        $actuaciones =  Actuacion::with('contrato','lista')
        ->where('contratos_id', '=', $actuacion->contratos_id)
        ->get();

        $contrato = Contratos::find($actuacion->contratos_id);
        $tipoActuacion = Tipoactuacion::all();

        return view('livewire.contratos.actuacions',compact('actuaciones','actuacion','tipoActuacion','contrato'));
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
        
            $actuacion->calendar = $this->generateICSFile($actuacion);

            // Guardar la actuación en la base de datos
            $actuacion->update();
        
            // Redireccionar a una página o devolver una respuesta JSON según tus necesidades
            $actuaciones =  Actuacion::with('contrato','lista')
            ->where('contratos_id', '=', $request->contratos_id)
            ->get();
        
            $contrato = Contratos::find($request->contratos_id);
            $tipoActuacion = Tipoactuacion::all();
            return view('livewire.contratos.actuacions',compact('actuaciones','tipoActuacion','contrato'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actuacion $actuacion)
    {
       
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        try {
        // Verificar si la actuación existe
            if ($actuacion) {
                $actuacion->delete();

                $cid = $actuacion->contratos_id;
                // Redireccionar a una página o devolver una respuesta JSON según tus necesidades
                $actuaciones =  Actuacion::with('contrato','lista')
                ->where('contratos_id', '=', $cid)
                ->get();

                $contrato = Contratos::find($cid);
                $tipoActuacion = Tipoactuacion::all();           
                
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            // Manejar la excepción de integridad referencial
            return redirect()->back()->with('error', 'No puedes eliminar esta actuación porque tiene listas relacionadas');
        }
        $eliminado=true;
        return view('livewire.contratos.actuacions',compact('actuaciones','tipoActuacion','contrato','eliminado'));            
         
    }

    public function getTotalActuacionesUsuario(User $user, $year = null)
    {
        if($user->id!=Auth::user()->id){
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
                //->where('disponible','<>','0')
                ->get();

            //dd($listasConActuaciones);
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
    
                if (!isset($totalesPorTipoActuacion[$tipoActuacionNombre])) {
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
            'usuario'=>$user, 
        ]);
    }


    /**
     * Obtiene las actuaciones de un usuario por año y poblacion
     */
    public function getActuacionesUsuarioPorPoblacionAnyo(User $user, $year, $poblacion)
    {
        $actuaciones = $user->listas()
        ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
        ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
        ->join('contratos', 'actuacions.contratos_id', '=', 'contratos.id')
        ->select('listas.*', 'actuacions.*','tipoactuacions.id AS tipoactuacion_id','tipoactuacions.nombre AS tipoactuacion_nombre','contratos.poblacion')
        ->whereYear('actuacions.fechaActuacion', $year) // Filtro por año actual
        ->where('contratos.poblacion',$poblacion)
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


        if (!empty($actuacionesGrph)) {
            $labels = collect($actuacionesGrph)->pluck('tipo')->toArray();
            $data = collect($actuacionesGrph)->pluck('total')->toArray();
        } else {
            $labels = ['Sin datos']; // Etiqueta predeterminada
            $data = [0]; // Valor predeterminado para la gráfica
        }

        return view('actuaciones.listado-actuaciones-tipo-usuario', compact('actuaciones','year', 'user','tiposActuacion','poblaciones','filtropobla','labels', 'data'));
    }


/**
 * listado de actuaciones de un usuario por año y tipo
 */

    public function getListadoActuacionesUsuarioAndTipo(User $user, $year, $type)
    {
        if($user->id!=Auth::user()->id){
            abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        $actuaciones = $user->listas()
        ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
        ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
        ->join('contratos', 'actuacions.contratos_id', '=', 'contratos.id')
        ->select('listas.*', 'actuacions.*','tipoactuacions.id AS tipoactuacion_id','tipoactuacions.nombre AS tipoactuacion_nombre','contratos.poblacion')
        ->whereYear('actuacions.fechaActuacion', $year) // Filtro por año actual
        ->where('tipoactuacions.id',$type)
        ->orderBy('actuacions.fechaActuacion', 'asc') // Ordenar por fechaActuacion ascendente
        ->get();
    
        $tiposActuacion = $actuaciones->pluck('tipoactuacion_nombre', 'tipoactuacion_id')->unique();        
        $poblaciones = $actuaciones->pluck('poblacion')->unique();  

        $filtrotipo=true; 

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


        if (!empty($actuacionesGrph)) {
            $labels = collect($actuacionesGrph)->pluck('tipo')->toArray();
            $data = collect($actuacionesGrph)->pluck('total')->toArray();
        } else {
            $labels = ['Sin datos']; // Etiqueta predeterminada
            $data = [0]; // Valor predeterminado para la gráfica
        }
        
        // Puedes pasar $actuaciones a la vista para mostrar el listado
        return view('actuaciones.listado-actuaciones-tipo-usuario', compact('actuaciones','year', 'user','tiposActuacion','poblaciones','filtrotipo','labels','data'));
        
    }



    public function getListadoActuacionesUsuarioAndPoblacion(User $user, $year, $poblacion)
    {
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


        if (!empty($actuacionesGrph)) {
            $labels = collect($actuacionesGrph)->pluck('tipo')->toArray();
            $data = collect($actuacionesGrph)->pluck('total')->toArray();
        } else {
            $labels = ['Sin datos']; // Etiqueta predeterminada
            $data = [0]; // Valor predeterminado para la gráfica
        }

        // Indicador de filtro de población
        $filtropobla = true;

        return view('actuaciones.view-listas', compact('actuacionesPorMes', 'tiposActuacion', 'meses', 'filtropobla', 'poblaciones','user', 'labels', 'data'));
    }


/**
 * Listado de actuacions filtradas por usuario y año
 */

    public function getListadoActuacionesUsuarioAnyo(User $user, $year)
    {
        if($user->id!=Auth::user()->id){
            abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
  
        $actuaciones = $user->listas()
        ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
        ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
        ->join('contratos', 'actuacions.contratos_id', '=', 'contratos.id')
        ->select('listas.*', 'actuacions.*','tipoactuacions.id AS tipoactuacion_id','tipoactuacions.nombre AS tipoactuacion_nombre','contratos.poblacion')
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
                `tipoactuacions`.`nombre`
                order by
                `total` desc';

        $actuacionesGrph = DB::select($sql);    


        if (!empty($actuacionesGrph)) {
            $labels = collect($actuacionesGrph)->pluck('tipo')->toArray();
            $data = collect($actuacionesGrph)->pluck('total')->toArray();
        } else {
            $labels = ['Sin datos']; // Etiqueta predeterminada
            $data = [0]; // Valor predeterminado para la gráfica
        }

        // Puedes pasar $actuaciones a la vista para mostrar el listado
    return view('actuaciones.listado-actuaciones-tipo-usuario', compact('actuaciones','year', 'user','tiposActuacion','poblaciones','labels','data'));
    }




public function generateICSFile($evento)
    {    
        // Contenido del archivo .ics
        $content =  "BEGIN:VCALENDAR\r\n";
        $content .= "VERSION:2.0\r\n";
        $content .= "PRODID:-//eBand\r\n";
        $content .= "BEGIN:VEVENT\r\n";
        $content .= "UID:" . uniqid() . "\r\n"; // Generar un ID único para el evento
        $content .= "DTSTAMP;VALUE=DATE-TIME:" . Carbon::now()->format('Ymd\THis'). "\r\n"; // Fecha y hora actual
        $content .= "DTSTART;VALUE=DATE-TIME:".Carbon::parse($evento->fechaActuacion)->format('Ymd\THis')."\r\n"; // Fecha y hora de inicio del evento
        $content .= "DTEND;VALUE=DATE-TIME:".Carbon::parse($evento->fechaActuacion)->format('Ymd\THis')."\r\n"; // Fecha y hora de fin del evento
        $content .= "SUMMARY:".Config::get('app.banda', 'eBand')." - ".$evento->descripcion."\r\n";
        $content .= "DESCRIPTION:".$evento->observaciones." - ".Config::get('app.url')."/actuacion/".$evento->id." \r\n";
        //$content .= "LOCATION:Calle Gandía, 21, 46892, Montaverner\r\n";
        //$content .= "GEO:38.8891800060307;-0.495599999999996\r\n";
        $content .= "END:VEVENT\r\n";
        $content .= "END:VCALENDAR\r\n";

        $newFileName = 'event_' . time() . '.ics'; 
        Storage::put('eventos/'.$newFileName, $content);
        return $newFileName;
    }

    public function descargarCalendario(Request $request, $actuacionId)
    {
        $actuacion = Actuacion::find($actuacionId);
    
        if (!$actuacion) {
            abort(404); // Actuación no encontrada
        }
    
        return Storage::download('eventos/'.$actuacion->calendar);
    }





    /**
     * Filtra las actuaciones por tipo en el calendario principal
     */

    public function getActuacionesPorTipo(Request $request, $tipoActuiacionId){
                
        $actuaciones = Actuacion::with('contrato', 'lista','tipoactuacion')
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

        $filtrotipo=true;

    return view('actuaciones.view-listas', compact('actuacionesPorMes','tiposActuacion', 'meses','filtrotipo','poblaciones'));

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
    
}
