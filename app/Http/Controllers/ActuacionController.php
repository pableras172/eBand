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
     
            // Obtener tipos de actuación únicos
            $tiposActuacion = $actuaciones->pluck('tipoactuacion')->unique();

            // Obtener meses únicos
            $meses = $actuaciones->pluck('fechaActuacion')->map(function ($date) {
                return Carbon::parse($date)->format('m/Y');
            })->unique();


         $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
             return Carbon::parse($actuacion->fechaActuacion)->format('m/Y');
         });
     
         return view('actuaciones.view-listas', compact('actuacionesPorMes','tiposActuacion', 'meses'));
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
     * Store a newly created resource in storage.
     */
public function store(Request $request)
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
    $actuacion->pagado = false;
    $actuacion->observaciones = $request->observaciones;

    // Guardar la actuación en la base de datos
    $actuacion->save();

    // Redireccionar a una página o devolver una respuesta JSON según tus necesidades
    $actuaciones =  Actuacion::with('contrato','lista')
    ->where('contratos_id', '=', $request->contratos_id)
    ->get();

    $contrato = Contratos::find($request->contratos_id);
    $tipoActuacion = Tipoactuacion::all();
    return view('livewire.contratos.actuacions',compact('actuaciones','tipoActuacion','contrato'));
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
                'message' =>  Lang::get('messages.no_actuations_found'),
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
            'message' =>  Lang::get('messages.notification_sent'),
            'alert_type' => 'success'
        );
        return response()->json($notification, 200);                 
    } catch (Exception $e) {        
        $notification = array(
            'message' =>  Lang::get('messages.notification_fail'),
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
                $notification = array(
                    'message' =>  Lang::get('messages.no_actuations_found'),
                    'alert_type' => 'warning'
                );
                return response()->json($notification, 404);
            }
    
            // Formatear la fecha
            $fechaFormateada = Carbon::parse($actuaciones->fechaActuacion)->format('d-m-Y');
    
            $asistentes = ListasUser::where('listas_id', $request->id)
                ->where('disponible', 1)                       
                ->get();
    
            // Verificar si se encontraron músicos
            if ($asistentes->isEmpty()) {
                $notification = array(
                    'message' =>  Lang::get('messages.no_musicians_found'),
                    'alert_type' => 'warning'
                );
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
                    env('APP_URL') . "/listas/actuacion/" . $request->id, 
                    null, 
                    null, 
                    null, 
                    $message, 
                    Lang::get('messages.view_details')
                );
            }
            $notification = array(
                'message' =>  Lang::get('messages.notification_sent'),
                'alert_type' => 'success'
            );
            return response()->json($notification, 200);
        } catch (Exception $e) {
            $notification = array(
                'message' =>  Lang::get('messages.notification_fail').' - '.$e->getMessage(),
                'alert_type' => 'error'
            );
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
            $actuacion->pagado = false;
            $actuacion->observaciones = $request->observaciones;
        
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

    public function getListadoActuacionesUsuarioAndTipo(User $user, $year, $type)
    {
        if($user->id!=Auth::user()->id){
            abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
        // Obtener las actuaciones del usuario para el año y tipo especificados
        $actuaciones = $user->listas()
            ->whereHas('actuacion', function ($query) use ($year, $type) {
                $query->whereYear('fechaActuacion', $year)
                    ->whereHas('tipoactuacion', function ($query) use ($type) {
                        $query->where('id', $type);
                    });
            })
            ->with('actuacion.tipoactuacion', 'actuacion.contrato')
            ->get();

        // Puedes pasar $actuaciones a la vista para mostrar el listado
        return view('actuaciones.listado-actuaciones-tipo-usuario', [
            'actuaciones' => $actuaciones,
            'year' => $year,
            'type' => $type,
            'usuario'=>$user,        
        ]);
}

    
}
