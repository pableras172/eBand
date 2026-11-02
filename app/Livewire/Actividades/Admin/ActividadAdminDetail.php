<?php

declare(strict_types=1);

namespace App\Livewire\Actividades\Admin;

use App\Models\Actividad;
use App\Models\ActividadInscripcion;
use App\Models\ActividadInscripcionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use OneSignal;
use Throwable;

class ActividadAdminDetail extends Component
{
    public Actividad $actividad;

    public bool $showingPaymentModal = false;

    public ?int $selectedInscripcionId = null;

    public string $modalMetodoPago = 'bizum';

    public string $searchInscritos = '';

    public string $filtroPago = '';

    // Modal de Inscripción por Admin (Miembro o Manual)
    public bool $showingInscripcionModal = false;

    public ?int $editingInscripcionId = null;

    public string $tipoAsistente = 'miembro'; // 'miembro' o 'manual'

    public ?int $selectedUserId = null;

    public string $nombreManual = '';

    /**
     * @var array<int, int>
     */
    public array $cantidades = [];

    public string $observaciones_alergias = '';

    public bool $marcarPagado = false;

    public string $metodoPago = 'efectivo';

    public float $totalCalculado = 0.0;

    public function mount(int $actividadId): void
    {
        abort_if(! Gate::allows('admin'), 403, 'No autorizado para gestionar actividades.');

        $this->actividad = Actividad::query()
            ->with(['opciones'])
            ->findOrFail($actividadId);
    }

    public function openCreateInscripcionModal(): void
    {
        $this->resetErrorBag();
        $this->editingInscripcionId = null;
        $this->tipoAsistente = 'miembro';
        $this->selectedUserId = null;
        $this->nombreManual = '';
        $this->observaciones_alergias = '';
        $this->marcarPagado = false;
        $this->metodoPago = 'efectivo';

        $this->cantidades = [];
        foreach ($this->actividad->opciones as $opcion) {
            $this->cantidades[$opcion->id] = 0;
        }

        $this->calcularTotal();
        $this->showingInscripcionModal = true;
    }

    public function openEditInscripcionModal(int $inscripcionId): void
    {
        $this->resetErrorBag();
        $inscripcion = ActividadInscripcion::query()
            ->with(['items.opcion'])
            ->findOrFail($inscripcionId);

        $this->editingInscripcionId = $inscripcionId;

        if ($inscripcion->user_id) {
            $this->tipoAsistente = 'miembro';
            $this->selectedUserId = $inscripcion->user_id;
            $this->nombreManual = '';
        } else {
            $this->tipoAsistente = 'manual';
            $this->selectedUserId = null;
            $this->nombreManual = $inscripcion->nombre_manual ?? '';
        }

        $this->observaciones_alergias = $inscripcion->observaciones_alergias ?? '';
        $this->marcarPagado = (bool) $inscripcion->pagado;
        $this->metodoPago = $inscripcion->metodo_pago ?? 'efectivo';

        $this->cantidades = [];
        $itemsPorOpcion = $inscripcion->items->keyBy('actividad_opcion_id');
        foreach ($this->actividad->opciones as $opcion) {
            $this->cantidades[$opcion->id] = $itemsPorOpcion->has($opcion->id)
                ? (int) $itemsPorOpcion->get($opcion->id)->cantidad
                : 0;
        }

        $this->calcularTotal();
        $this->showingInscripcionModal = true;
    }

    public function incrementarCantidad(int $opcionId): void
    {
        if (isset($this->cantidades[$opcionId])) {
            $this->cantidades[$opcionId]++;
            $this->calcularTotal();
        }
    }

    public function decrementarCantidad(int $opcionId): void
    {
        if (isset($this->cantidades[$opcionId]) && $this->cantidades[$opcionId] > 0) {
            $this->cantidades[$opcionId]--;
            $this->calcularTotal();
        }
    }

    public function updatedCantidades(): void
    {
        $this->calcularTotal();
    }

    public function calcularTotal(): void
    {
        $total = 0.0;
        foreach ($this->actividad->opciones as $opcion) {
            $qty = (int) ($this->cantidades[$opcion->id] ?? 0);
            if ($qty > 0) {
                $total += $qty * (float) $opcion->precio;
            }
        }
        $this->totalCalculado = $total;
    }

    public function guardarInscripcion(): void
    {
        abort_if(! Gate::allows('admin'), 403);

        $this->resetErrorBag();

        if ($this->tipoAsistente === 'miembro') {
            $this->validate([
                'selectedUserId' => ['required', 'exists:users,id'],
            ], [
                'selectedUserId.required' => __('actividades.select_member_placeholder'),
            ]);

            // Comprobar que no esté repetido
            $yaRegistrado = ActividadInscripcion::query()
                ->where('actividad_id', $this->actividad->id)
                ->where('user_id', $this->selectedUserId)
                ->when($this->editingInscripcionId, fn ($q) => $q->where('id', '!=', $this->editingInscripcionId))
                ->exists();

            if ($yaRegistrado) {
                $this->addError('selectedUserId', __('actividades.error_already_registered'));

                return;
            }
        } else {
            $this->validate([
                'nombreManual' => ['required', 'string', 'max:255'],
            ]);
        }

        $this->calcularTotal();

        $totalCantidad = array_sum(array_map('intval', $this->cantidades));
        if ($totalCantidad <= 0) {
            $this->addError('cantidades', __('actividades.error_select_at_least_one'));

            return;
        }

        DB::transaction(function (): void {
            if ($this->editingInscripcionId) {
                $inscripcion = ActividadInscripcion::query()->findOrFail($this->editingInscripcionId);
                $inscripcion->update([
                    'user_id' => $this->tipoAsistente === 'miembro' ? $this->selectedUserId : null,
                    'nombre_manual' => $this->tipoAsistente === 'manual' ? trim($this->nombreManual) : null,
                    'total' => $this->totalCalculado,
                    'observaciones_alergias' => trim($this->observaciones_alergias) ?: null,
                    'pagado' => $this->marcarPagado,
                    'metodo_pago' => $this->marcarPagado ? $this->metodoPago : null,
                    'fecha_pago' => $this->marcarPagado ? ($inscripcion->fecha_pago ?? Carbon::now()) : null,
                ]);

                $inscripcion->items()->delete();
            } else {
                $inscripcion = ActividadInscripcion::query()->create([
                    'actividad_id' => $this->actividad->id,
                    'user_id' => $this->tipoAsistente === 'miembro' ? $this->selectedUserId : null,
                    'nombre_manual' => $this->tipoAsistente === 'manual' ? trim($this->nombreManual) : null,
                    'fecha_inscripcion' => Carbon::now(),
                    'total' => $this->totalCalculado,
                    'observaciones_alergias' => trim($this->observaciones_alergias) ?: null,
                    'pagado' => $this->marcarPagado,
                    'metodo_pago' => $this->marcarPagado ? $this->metodoPago : null,
                    'fecha_pago' => $this->marcarPagado ? Carbon::now() : null,
                ]);
            }

            foreach ($this->actividad->opciones as $opcion) {
                $qty = (int) ($this->cantidades[$opcion->id] ?? 0);
                if ($qty > 0) {
                    ActividadInscripcionItem::query()->create([
                        'actividad_inscripcion_id' => $inscripcion->id,
                        'actividad_opcion_id' => $opcion->id,
                        'cantidad' => $qty,
                        'precio_unitario' => $opcion->precio,
                        'subtotal' => $qty * (float) $opcion->precio,
                    ]);
                }
            }

            $nombre = $inscripcion->nombre_completo;
            session()->flash('success', __('actividades.registration_saved_success', ['name' => $nombre]));
        });

        $this->showingInscripcionModal = false;
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

        session()->flash('success', __('actividades.payment_marked_paid', ['name' => $inscripcion->nombre_completo, 'metodo' => $this->modalMetodoPago]));
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

        session()->flash('success', __('actividades.payment_marked_pending', ['name' => $inscripcion->nombre_completo]));
    }

    public function notificarOneSignal(): void
    {
        abort_if(! Gate::allows('admin'), 403);

        $url = route('actividades.show', $this->actividad->id);
        $fechaLimite = $this->actividad->fecha_limite_inscripcion->translatedFormat('d M Y, H:i');

        try {
            OneSignal::sendNotificationToSegment(
                __('actividades.notification_title', ['titulo' => $this->actividad->titulo]),
                'Active Subscriptions',
                $url,
                null,
                null,
                null,
                __('actividades.notification_subtitle', ['fecha' => $fechaLimite]),
                __('actividades.inscribe')
            );

            $this->actividad->update([
                'notified_at' => Carbon::now(),
            ]);

            session()->flash('success', __('actividades.notification_sent'));
        } catch (Throwable $e) {
            session()->flash('error', 'Error OneSignal: '.$e->getMessage());
        }
    }

    public function eliminarInscripcion(int $inscripcionId): void
    {
        abort_if(! Gate::allows('admin'), 403);

        $inscripcion = ActividadInscripcion::query()->findOrFail($inscripcionId);
        $userName = $inscripcion->nombre_completo;
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
                $term = $this->searchInscritos;
                $q->where(function ($sub) use ($term): void {
                    $sub->whereHas('user', function ($u) use ($term): void {
                        $u->where('name', 'like', "%{$term}%")
                            ->orWhere('email', 'like', "%{$term}%");
                    })->orWhere('nombre_manual', 'like', "%{$term}%");
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

        $usuariosDisponibles = User::query()
            ->select(['id', 'name', 'email'])
            ->orderBy('name')
            ->get();

        return view('livewire.actividades.admin.actividad-admin-detail', [
            'recuentoOpciones' => $recuentoOpciones,
            'totalPersonasInscritas' => $totalPersonasInscritas,
            'totalPrevisto' => $totalPrevisto,
            'totalCobrado' => $totalCobrado,
            'totalPendiente' => $totalPendiente,
            'inscritos' => $inscritos,
            'usuariosDisponibles' => $usuariosDisponibles,
        ]);
    }
}
