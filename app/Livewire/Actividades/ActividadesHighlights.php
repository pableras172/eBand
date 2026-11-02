<?php

declare(strict_types=1);

namespace App\Livewire\Actividades;

use App\Models\Actividad;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActividadesHighlights extends Component
{
    public function render(): View
    {
        if (! Auth::check()) {
            return view('livewire.actividades.actividades-highlights', [
                'actividades' => collect(),
            ]);
        }

        $userId = Auth::id();

        // Obtenemos las próximas actividades activas (fecha de hoy en adelante)
        $actividades = Actividad::query()
            ->where('estado', '!=', 'borrador')
            ->where('fecha', '>=', Carbon::now()->startOfDay())
            ->with(['opciones'])
            ->with([
                'inscripciones' => function ($q) use ($userId): void {
                    $q->where('user_id', $userId);
                },
            ])
            ->orderBy('fecha', 'asc')
            ->limit(4)
            ->get();

        return view('livewire.actividades.actividades-highlights', [
            'actividades' => $actividades,
        ]);
    }
}
