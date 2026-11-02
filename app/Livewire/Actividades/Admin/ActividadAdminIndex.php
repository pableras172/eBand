<?php

declare(strict_types=1);

namespace App\Livewire\Actividades\Admin;

use App\Models\Actividad;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use OneSignal;
use Throwable;

class ActividadAdminIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filtroTipo = '';

    public string $filtroEstado = '';

    public bool $confirmingDeletion = false;

    public ?int $deletingActividadId = null;

    public function mount(): void
    {
        abort_if(! Gate::allows('admin'), 403, 'No autorizado para gestionar actividades.');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFiltroTipo(): void
    {
        $this->resetPage();
    }

    public function updatedFiltroEstado(): void
    {
        $this->resetPage();
    }

    public function cambiarEstado(int $actividadId, string $nuevoEstado): void
    {
        abort_if(! Gate::allows('admin'), 403);

        $actividad = Actividad::query()->findOrFail($actividadId);

        if (in_array($nuevoEstado, ['borrador', 'abierta', 'cerrada'], true)) {
            $actividad->update(['estado' => $nuevoEstado]);
            session()->flash('success', "Estado de «{$actividad->titulo}» cambiado a {$nuevoEstado}.");
        }
    }

    public function notificarOneSignal(int $actividadId): void
    {
        abort_if(! Gate::allows('admin'), 403);

        $actividad = Actividad::query()->findOrFail($actividadId);
        $url = route('actividades.show', $actividad->id);
        $fechaLimite = $actividad->fecha_limite_inscripcion->translatedFormat('d M Y, H:i');

        try {
            OneSignal::sendNotificationToSegment(
                __('actividades.notification_title', ['titulo' => $actividad->titulo]),
                'Active Subscriptions',
                $url,
                null,
                null,
                null,
                __('actividades.notification_subtitle', ['fecha' => $fechaLimite]),
                __('actividades.inscribe')
            );

            $actividad->update([
                'notified_at' => Carbon::now(),
            ]);

            session()->flash('success', __('actividades.notification_sent'));
        } catch (Throwable $e) {
            session()->flash('error', 'Error OneSignal: '.$e->getMessage());
        }
    }

    public function confirmDeletion(int $actividadId): void
    {
        $this->deletingActividadId = $actividadId;
        $this->confirmingDeletion = true;
    }

    public function delete(): void
    {
        abort_if(! Gate::allows('admin'), 403);

        if (! $this->deletingActividadId) {
            return;
        }

        $actividad = Actividad::query()->findOrFail($this->deletingActividadId);
        $titulo = $actividad->titulo;
        $actividad->delete();

        $this->confirmingDeletion = false;
        $this->deletingActividadId = null;

        session()->flash('success', __('actividades.activity_deleted', ['titulo' => $titulo]));
    }

    public function render(): View
    {
        $query = Actividad::query()
            ->withCount(['opciones', 'inscripciones'])
            ->withSum('inscripciones', 'total')
            ->when($this->search !== '', function ($q): void {
                $q->where(function ($sub): void {
                    $sub->where('titulo', 'like', "%{$this->search}%")
                        ->orWhere('lugar', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filtroTipo !== '', function ($q): void {
                $q->where('tipo', $this->filtroTipo);
            })
            ->when($this->filtroEstado !== '', function ($q): void {
                $q->where('estado', $this->filtroEstado);
            })
            ->orderBy('fecha', 'desc');

        /** @var LengthAwarePaginator $actividades */
        $actividades = $query->paginate(15);

        return view('livewire.actividades.admin.actividad-admin-index', [
            'actividades' => $actividades,
        ]);
    }
}
