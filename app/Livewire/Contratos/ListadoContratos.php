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

class ListadoContratos extends Component
{

    public function index()
    {
        $contratos = Contratos::orderBy('fechainicio', 'asc')->paginate(10); // Esto paginará los resultados mostrando 10 registros por página
        return view('livewire.contratos.index', compact('contratos'));
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
        $request->validate([
            'poblacion' => 'required|string|max:255',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'descripcion' => 'required|string',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'anyo' => 'nullable|integer|min:1900|max:' . date('Y'),
            'dnicontacto' => 'nullable|string|max:20',
            'observacions' => 'nullable|string',
        ]);

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
        $contrato->save();
    
        return redirect()->route('contratos.index')
            ->with('success', 'Contrato creado correctamente.');
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
        'anyo' => 'nullable|integer|min:1900|max:' . date('Y'),
        'dnicontacto' => 'nullable|string|max:20',
        'observacions' => 'nullable|string',
    ]);

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

    // Guardar los cambios en el contrato
    $contrato->save();

    // Redireccionar con mensaje de éxito
    return redirect()->route('contratos.index')
        ->with('success', 'Contrato actualizado correctamente.');
}



/**
 * Remove the specified resource from storage.
 */
public function destroy(Contratos $contrato)
{
    $contrato->delete();

    return redirect()->route('contratos.index')
        ->with('success', 'Contrato eliminado correctamente.');
}



}
