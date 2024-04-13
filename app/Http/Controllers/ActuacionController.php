<?php

namespace App\Http\Controllers;

use App\Models\Actuacion;
use App\Models\Contratos;
use App\Models\Tipoactuacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use OneSignal;
use App\Models\User;
use App\Models\ListasUser;

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
     
      
         $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
             return Carbon::parse($actuacion->fechaActuacion)->format('m/Y');
         });
     
         return view('actuaciones.view-listas', compact('actuacionesPorMes'));
     }
     
    
    /**
     * Show the form for creating a new resource.
     */
    public function createtocontract(Request $request, string $id)
    {
        $actuaciones =  Actuacion::with('contrato','lista')
        ->where('contratos_id', '=', $id)
        ->orderBy('fechaActuacion', 'asc')
        ->get();

        $tipoActuacion = Tipoactuacion::all();

        $contrato = Contratos::find($id);

        return view('livewire.contratos.actuacions',compact('actuaciones','tipoActuacion','contrato'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
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
        // Validar los datos de entrada
        $request->validate([
            'id' => 'required|integer',        
        ]);    
        
        $actuaciones = Actuacion::with('contrato', 'lista')
            ->where('id', '=', $request->id)
            ->get();  
        
        // Verifica si se encontraron actuaciones
        if ($actuaciones->isEmpty()) {
            return response()->json(['message' => 'No se encontraron actuaciones con el ID proporcionado'], 404);
        }

        // Formatear la fecha
        $fechaFormateada = Carbon::parse($actuaciones[0]->fechaActuacion)->format('d-m-Y');

        // Enviar notificación OneSignal
        OneSignal::sendNotificationToSegment(
            "El proper ".$fechaFormateada." - ".$actuaciones[0]->descripcion,
            "Active Subscriptions", 
            env('APP_URL')."/listas/actuacion/".$request->id, 
            null, 
            null, 
            null, 
            "Nova actuació - ".$actuaciones[0]->contrato->poblacion, 
            "Accedix per a vore els detalls"
        );

        // Devolver una respuesta adecuada
        return response()->json(['message' => 'Notificación enviada correctamente'], 200);
    }

    public function notificarActuacionLista(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'id' => 'required|integer',        
        ]);    
        
        $asistentes = ListasUser::where('listas_id', $request->id)->get();
        
        // Verifica si se encontraron actuaciones
        if ($asistentes->isEmpty()) {
            return response()->json(['message' => 'No se encontraron musicos para la actuación'], 404);
        }

        $actuaciones = Actuacion::with('contrato', 'lista')
        ->where('id', '=', $request->id)
        ->get();  

        // Formatear la fecha
        $fechaFormateada = Carbon::parse($actuaciones[0]->fechaActuacion)->format('d-m-Y');

        foreach ($asistentes as $asistente) {

            $dest = User::where('id', $asistente->user_id)->first();
            if (!$dest || !$dest->uuid) {
                continue;
            }

            $message = "Tens una nova actuació  - ".$actuaciones[0]->contrato->poblacion;

            if($asistente->coche){
                $message = "Tens una nova actuació agafant el cotxe  - ".$actuaciones[0]->contrato->poblacion;
            }


            OneSignal::sendNotificationToExternalUser(
                "El proper ".$fechaFormateada." - ".$actuaciones[0]->descripcion,
                $dest->uuid,
                env('APP_URL')."/listas/actuacion/".$request->id, 
                null, 
                null, 
                null, 
                $message, 
                "Accedix per a vore els detalls"
            );
        }

        return response()->json(['message' => 'Notificación enviada correctamente'], 200);
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
        // Redireccionar a una página o devolver una respuesta JSON según tus necesidades
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
    
}
