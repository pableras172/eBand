<?php

declare(strict_types=1);

namespace App\Livewire\Actividades;

use App\Models\Actividad;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActividadesIndex extends Component
{
    public string $filtroTipo = '';

    public function render(): View
    {
        $userId = Auth::id();

        $actividades = Actividad::query()
            ->with(['opciones'])
            ->with([
                'inscripciones' => function ($q) use ($userId): void {
                    $q->where('user_id', $userId);
                },
            ])
            ->where('estado', '!=', 'borrador')
            ->when($this->filtroTipo !== '', function ($q): void {
                $q->where('tipo', $this->filtroTipo);
            })
            ->orderBy('fecha', 'asc')
            ->get();

        return view('livewire.actividades.actividades-index', [
            'actividades' => $actividades,
        ]);
    }
}
