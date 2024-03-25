<?php

namespace App\Http\Controllers;

use App\Models\Contratos;
use Illuminate\Http\Request;

class ContratosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contratos = Contratos::all();
        return view('contratos.index', compact('contratos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contratos.create');
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
        return view('contratos.show', compact('contrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contratos $contrato)
    {
        return view('contratos.edit', compact('contrato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contratos $contrato)
    {
        $request->validate([
            // Aquí puedes definir las reglas de validación para los campos del contrato
        ]);

        $contrato->update($request->all());

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

    public function filtrar(Request $request)
    {
        $query = Contratos::query();

        if ($request->filled('year')) {
            $query->where('anyo', $request->year);
        }

        if ($request->filled('poblacion')) {
            $query->where('poblacion', $request->poblacion);
        }

        $contratos = $query->get();

        return view('contratos.index', compact('contratos'));
    }

}
