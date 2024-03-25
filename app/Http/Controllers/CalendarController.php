<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Obtener el mes y año actuales
        $mesActual = Carbon::now()->month;
        $añoActual = Carbon::now()->year;

        return view('livewire.calendario.showcalendar', [
            'mesSeleccionado' => $mesActual,
            'añoSeleccionado' => $añoActual,
        ]);
    }

    public function mostrarCalendario($año, $mes)
    {       
        return view('livewire.calendario.showcalendar', [
            'añoSeleccionado' => $año,
            'mesSeleccionado' => $mes,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Calendar $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calendar $calendar)
    {
        //
    }
}
