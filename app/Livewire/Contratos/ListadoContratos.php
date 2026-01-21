<?php

namespace App\Livewire\Contratos;

use App\Models\Contratos;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ListadoContratos extends Component
{

    public function index($year = null)
    {
        if ($year === null) {
            $year = Carbon::now()->year;
        }

        $contratos = Contratos::whereYear('fechainicio', '<=', $year) // empezó antes o ese año
            ->whereYear('fechafin', '>=', $year)   // termina ese año o después
            ->orderBy('fechainicio', 'asc')
            ->paginate(10);

        return view('livewire.contratos.index', compact('contratos', 'year'));
    }



    public function contratosPorAnyo($year = null)
    {
        if ($year === null) {
            $year = Carbon::now()->year;
        }

        $contratos = Contratos::whereYear('fechainicio', '<=', $year) // empezó antes o ese año
            ->whereYear('fechafin', '>=', $year)   // termina ese año o después
            ->orderBy('fechainicio', 'asc')
            ->paginate(10);

        return view('livewire.contratos.index', compact('contratos', 'year'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('livewire.contratos.contrato');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $request->validate([
            'poblacion' => 'required|string|max:255',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'descripcion' => 'required|string',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'anyo' => 'nullable|integer|min:1900|max:' . date('Y')+5,
            'dnicontacto' => 'nullable|string|max:20',
            'observacions' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);


        try {


            $contrato = new Contratos();
            $contrato->poblacion = $request->poblacion;
            $contrato->fechainicio = $request->fechainicio;
            $contrato->fechafin = $request->fechafin;
            $contrato->descripcion = $request->descripcion;
            $contrato->contacto = $request->contacto;
            $contrato->telefono = $request->telefono;
            $contrato->correo = $request->correo;
            $contrato->anyo = $request->anyo;
            $contrato->dnicontacto = $request->dnicontacto;
            $contrato->observacions = $request->observacions;
            $contrato->latitude = $request->latitude;
            $contrato->longitude = $request->longitude;

            $contrato->save();
        } catch (\Throwable $e) {
            Log::error('Error al guardar contrato', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
        return redirect()->route('contratos.index')
            ->with('success', __('Contrato creado correctamente.'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Contratos $contrato)
    {
        return view('livewire.contratos.show', compact('contrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contratos $contrato)
    {
        return view('livewire.contratos.contrato', compact('contrato'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contratos $contrato)
    {
        $request->validate([
            'poblacion' => 'required|string|max:255',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'descripcion' => 'required|string',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'anyo' => 'nullable|integer|min:1900|max:' . date('Y')+5,
            'dnicontacto' => 'nullable|string|max:20',
            'observacions' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
           
        
        // Establecer cada campo del contrato con los valores del request
        $contrato->poblacion = $request->poblacion;
        $contrato->fechainicio = $request->fechainicio;
        $contrato->fechafin = $request->fechafin;
        $contrato->descripcion = $request->descripcion;
        $contrato->contacto = $request->contacto;
        $contrato->telefono = $request->telefono;
        $contrato->correo = $request->correo;
        $contrato->anyo = $request->anyo;
        $contrato->dnicontacto = $request->dnicontacto;
        $contrato->observacions = $request->observacions;
        $contrato->latitude = $request->latitude;
        $contrato->longitude = $request->longitude;

        // Guardar los cambios en el contrato
        $contrato->save();

        } catch (\Throwable $e) {
            Log::error('Error al encontrar contrato para actualizar', [
                'contrato_id' => $contrato->id ?? null,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        // Redireccionar con mensaje de éxito
        return redirect()->route('contratos.index')
            ->with('success', __('Contrato actualizado correctamente.'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contratos $contrato)
    {

        try {
            if ($contrato) {
                $contrato->delete();
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect()->back()->with('error', __('No se ha podido eliminar el contrato.'));
        }

        return redirect()->route('contratos.index')
            ->with('deletesuccess', __('Contrato eliminado correctamente.'));
    }
}
