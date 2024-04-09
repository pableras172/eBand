<?php

namespace App\Http\Controllers;

use App\Models\Actuacion;
use App\Models\Contratos;
use App\Models\Tipoactuacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use OneSignal;

class ActuacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

     public function index()
     {
         $actuaciones = Actuacion::with('contrato', 'listas','tipoactuacion')
             ->whereDate('fechaActuacion', '>=', now()->toDateString())
             ->orderBy('fechaActuacion', 'asc') // Ordenar por fechaActuacion ascendente
             ->get();
     
         // Agrupar las actuaciones por mes
         $actuacionesPorMes = $actuaciones->groupBy(function ($actuacion) {
             return Carbon::parse($actuacion->fechaActuacion)->format('F Y');
         });
     
         return view('actuaciones.view-listas', compact('actuacionesPorMes'));
     }
     
    
    /**
     * Show the form for creating a new resource.
     */
    public function createtocontract(Request $request, string $id)
    {
        $actuaciones =  Actuacion::with('contrato','listas')
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
    $actuaciones =  Actuacion::with('contrato','listas')
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
        
        $actuaciones = Actuacion::with('contrato', 'listas')
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
        $actuaciones =  Actuacion::with('contrato','listas')
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
            $actuaciones =  Actuacion::with('contrato','listas')
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
                // Redireccionar a una página o devolver una respuesta JSON según tus necesidades
                $actuaciones =  Actuacion::with('contrato','listas')
                ->where('contratos_id', '=', $actuacion->contratos_id)
                ->get();

                $contrato = Contratos::find($actuacion->contratos_id);
                $tipoActuacion = Tipoactuacion::all();
            
                $actuacion->delete();
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            // Manejar la excepción de integridad referencial
            return redirect()->back()->with('error', 'No puedes eliminar esta actuación porque tiene listas relacionadas');
        }
        $eliminado=true;
        return view('livewire.contratos.actuacions',compact('actuaciones','tipoActuacion','contrato','eliminado'));            
         
    }
    
}
