<?php

declare(strict_types=1);

namespace App\Livewire\Actividades\Admin;

use App\Models\Actividad;
use App\Models\ActividadInscripcion;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ActividadAdminDetail extends Component
{
    public Actividad $actividad;

    public bool $showingPaymentModal = false;

    public ?int $selectedInscripcionId = null;

    public string $modalMetodoPago = 'bizum';

    public string $searchInscritos = '';

    public string $filtroPago = '';

    public function mount(int $actividadId): void
    {
        abort_if(! Gate::allows('admin'), 403, 'No autorizado para gestionar actividades.');

        $this->actividad = Actividad::query()
            ->with(['opciones'])
            ->findOrFail($actividadId);
    }

    public function openPaymentModal(int $inscripcionId): void
    {
        $this->selectedInscripcionId = $inscripcionId;
        $inscripcion = ActividadInscripcion::query()->findOrFail($inscripcionId);
        $this->modalMetodoPago = $inscripcion->metodo_pago ?? 'bizum';
        $this->showingPaymentModal = true;
    }

    public function guardarPago(): void
    {
        abort_if(! Gate::allows('admin'), 403);

        if (! $this->selectedInscripcionId) {
            return;
        }

        $inscripcion = ActividadInscripcion::query()->findOrFail($this->selectedInscripcionId);
        $inscripcion->update([
            'pagado' => true,
            'metodo_pago' => $this->modalMetodoPago,
            'fecha_pago' => Carbon::now(),
        ]);

        $this->showingPaymentModal = false;
        $this->selectedInscripcionId = null;

        session()->flash('success', __('actividades.payment_marked_paid', ['name' => $inscripcion->user->name, 'metodo' => $this->modalMetodoPago]));
    }

    public function marcarPendiente(int $inscripcionId): void
    {
        abort_if(! Gate::allows('admin'), 403);

        $inscripcion = ActividadInscripcion::query()->findOrFail($inscripcionId);
        $inscripcion->update([
            'pagado' => false,
            'metodo_pago' => null,
            'fecha_pago' => null,
        ]);

        session()->flash('success', __('actividades.payment_marked_pending', ['name' => $inscripcion->user->name]));
    }

    public function eliminarInscripcion(int $inscripcionId): void
    {
        abort_if(! Gate::allows('admin'), 403);

        $inscripcion = ActividadInscripcion::query()->findOrFail($inscripcionId);
        $userName = $inscripcion->user->name;
        $inscripcion->delete();

        session()->flash('success', __('actividades.registration_deleted', ['name' => $userName]));
    }

    public function render(): View
    {
        // Recargar datos y relaciones
        $this->actividad->loadMissing('opciones');

        // Recuento por cada opción configurada
        $recuentoOpciones = $this->actividad->opciones->map(function ($opcion): array {
            $totalCantidad = (int) $opcion->inscripcionItems()->sum('cantidad');
            $totalImporte = (float) $opcion->inscripcionItems()->sum('subtotal');

            return [
                'id' => $opcion->id,
                'titulo' => $opcion->titulo,
                'precio' => (float) $opcion->precio,
                'cantidad' => $totalCantidad,
                'importe' => $totalImporte,
            ];
        });

        // Totales financieros
        $inscripcionesQuery = $this->actividad->inscripciones();
        $totalPersonasInscritas = (int) $inscripcionesQuery->count();
        $totalPrevisto = (float) $inscripcionesQuery->sum('total');
        $totalCobrado = (float) (clone $inscripcionesQuery)->where('pagado', true)->sum('total');
        $totalPendiente = $totalPrevisto - $totalCobrado;

        // Lista de inscritos con filtros
        $inscritos = ActividadInscripcion::query()
            ->where('actividad_id', $this->actividad->id)
            ->with(['user', 'items.opcion'])
            ->when($this->searchInscritos !== '', function ($q): void {
                $q->whereHas('user', function ($sub): void {
                    $sub->where('name', 'like', "%{$this->searchInscritos}%")
                        ->orWhere('email', 'like', "%{$this->searchInscritos}%");
                });
            })
            ->when($this->filtroPago === 'pagado', function ($q): void {
                $q->where('pagado', true);
            })
            ->when($this->filtroPago === 'pendiente', function ($q): void {
                $q->where('pagado', false);
            })
            ->orderBy('fecha_inscripcion', 'asc')
            ->get();

        return view('livewire.actividades.admin.actividad-admin-detail', [
            'recuentoOpciones' => $recuentoOpciones,
            'totalPersonasInscritas' => $totalPersonasInscritas,
            'totalPrevisto' => $totalPrevisto,
            'totalCobrado' => $totalCobrado,
            'totalPendiente' => $totalPendiente,
            'inscritos' => $inscritos,
        ]);
    }
}
