<?php

declare(strict_types=1);

namespace App\Livewire\Actividades;

use App\Models\Actividad;
use App\Models\ActividadInscripcion;
use App\Models\ActividadInscripcionItem;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActividadDetalle extends Component
{
    public Actividad $actividad;

    public ?ActividadInscripcion $miInscripcion = null;

    /**
     * Array asociativo: [ opcion_id => cantidad ]
     *
     * @var array<int, int>
     */
    public array $cantidades = [];

    public string $observaciones_alergias = '';

    public float $totalCalculado = 0.0;

    public function mount(int $actividadId): void
    {
        $this->actividad = Actividad::query()
            ->with(['opciones'])
            ->findOrFail($actividadId);

        if ($this->actividad->estado === 'borrador') {
            abort(404);
        }

        $userId = Auth::id();

        // Comprobar si el usuario ya está inscrito
        $this->miInscripcion = ActividadInscripcion::query()
            ->with(['items.opcion'])
            ->where('actividad_id', $this->actividad->id)
            ->where('user_id', $userId)
            ->first();

        // Inicializar cantidades a 0 para cada opción si no está inscrito
        if (! $this->miInscripcion) {
            foreach ($this->actividad->opciones as $opcion) {
                $this->cantidades[$opcion->id] = 0;
            }
        }
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

    public function inscribirme(): void
    {
        $userId = Auth::id();

        // Validaciones
        if (! $this->actividad->puedeInscribirse()) {
            $this->addError('error', __('actividades.error_closed'));

            return;
        }

        // Verificar si ya existe inscripción (evitar doble post)
        $existe = ActividadInscripcion::query()
            ->where('actividad_id', $this->actividad->id)
            ->where('user_id', $userId)
            ->exists();

        if ($existe) {
            $this->addError('error', __('actividades.error_already_registered'));

            return;
        }

        // Filtrar opciones seleccionadas con cantidad > 0
        $itemsAInsertar = [];
        $totalFinal = 0.0;

        foreach ($this->actividad->opciones as $opcion) {
            $qty = (int) ($this->cantidades[$opcion->id] ?? 0);
            if ($qty > 0) {
                $subtotal = $qty * (float) $opcion->precio;
                $totalFinal += $subtotal;
                $itemsAInsertar[] = [
                    'opcion_id' => $opcion->id,
                    'cantidad' => $qty,
                    'precio_unitario' => (float) $opcion->precio,
                    'subtotal' => $subtotal,
                ];
            }
        }

        if (empty($itemsAInsertar)) {
            $this->addError('cantidades', __('actividades.error_select_at_least_one'));

            return;
        }

        // Persistir inscripción
        DB::transaction(function () use ($userId, $totalFinal, $itemsAInsertar): void {
            $inscripcion = ActividadInscripcion::query()->create([
                'actividad_id' => $this->actividad->id,
                'user_id' => $userId,
                'fecha_inscripcion' => Carbon::now(),
                'total' => $totalFinal,
                'observaciones_alergias' => $this->actividad->requiereAlergias() ? ($this->observaciones_alergias ?: null) : null,
                'pagado' => false,
            ]);

            foreach ($itemsAInsertar as $item) {
                ActividadInscripcionItem::query()->create([
                    'actividad_inscripcion_id' => $inscripcion->id,
                    'actividad_opcion_id' => $item['opcion_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            $this->miInscripcion = $inscripcion->load(['items.opcion']);
        });

        session()->flash('success', __('actividades.registration_success'));
    }

    public function render(): View
    {
        return view('livewire.actividades.actividad-detalle');
    }
}
