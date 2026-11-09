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

    public bool $cambiandoRespuesta = false;

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

        // Comprobar si el usuario ya está inscrito o ha indicado no asistir
        $this->miInscripcion = ActividadInscripcion::query()
            ->with(['items.opcion'])
            ->where('actividad_id', $this->actividad->id)
            ->where('user_id', $userId)
            ->first();

        // Inicializar cantidades a 0 para cada opción si no está inscrito
        foreach ($this->actividad->opciones as $opcion) {
            $this->cantidades[$opcion->id] = 0;
        }

        if ($this->miInscripcion && $this->miInscripcion->asiste) {
            foreach ($this->miInscripcion->items as $item) {
                if (isset($this->cantidades[$item->actividad_opcion_id])) {
                    $this->cantidades[$item->actividad_opcion_id] = (int) $item->cantidad;
                }
            }
            $this->observaciones_alergias = $this->miInscripcion->observaciones_alergias ?? '';
            $this->calcularTotal();
        }
    }

    public function modificarOpciones(): void
    {
        if (! $this->actividad->puedeInscribirse()) {
            $this->addError('error', __('actividades.error_closed'));

            return;
        }

        foreach ($this->actividad->opciones as $opcion) {
            $this->cantidades[$opcion->id] = 0;
        }

        if ($this->miInscripcion && $this->miInscripcion->asiste) {
            foreach ($this->miInscripcion->items as $item) {
                if (isset($this->cantidades[$item->actividad_opcion_id])) {
                    $this->cantidades[$item->actividad_opcion_id] = (int) $item->cantidad;
                }
            }
            $this->observaciones_alergias = $this->miInscripcion->observaciones_alergias ?? '';
            $this->calcularTotal();
        }

        $this->cambiandoRespuesta = true;
    }

    public function cancelarEdicion(): void
    {
        $this->cambiandoRespuesta = false;

        foreach ($this->actividad->opciones as $opcion) {
            $this->cantidades[$opcion->id] = 0;
        }

        if ($this->miInscripcion && $this->miInscripcion->asiste) {
            foreach ($this->miInscripcion->items as $item) {
                if (isset($this->cantidades[$item->actividad_opcion_id])) {
                    $this->cantidades[$item->actividad_opcion_id] = (int) $item->cantidad;
                }
            }
            $this->observaciones_alergias = $this->miInscripcion->observaciones_alergias ?? '';
            $this->calcularTotal();
        } else {
            $this->observaciones_alergias = '';
            $this->totalCalculado = 0.0;
        }
    }

    public function toggleCambiarRespuesta(): void
    {
        if ($this->cambiandoRespuesta) {
            $this->cancelarEdicion();
        } else {
            $this->modificarOpciones();
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

    public function indicarNoVoy(): void
    {
        if (! $this->actividad->puedeInscribirse()) {
            $this->addError('error', __('actividades.error_closed'));

            return;
        }

        $userId = Auth::id();

        if ($this->actividad->es_de_pago && $this->miInscripcion && $this->miInscripcion->pagado) {
            $this->addError('error', __('actividades.error_paid_cannot_cancel'));

            return;
        }

        DB::transaction(function () use ($userId): void {
            if ($this->miInscripcion) {
                $this->miInscripcion->items()->delete();
                $this->miInscripcion->update([
                    'asiste' => false,
                    'total' => 0.0,
                    'observaciones_alergias' => null,
                    'fecha_inscripcion' => Carbon::now(),
                ]);
            } else {
                $this->miInscripcion = ActividadInscripcion::query()->create([
                    'actividad_id' => $this->actividad->id,
                    'user_id' => $userId,
                    'asiste' => false,
                    'fecha_inscripcion' => Carbon::now(),
                    'total' => 0.0,
                    'pagado' => false,
                ]);
            }

            $this->miInscripcion = $this->miInscripcion->fresh(['items.opcion']);
        });

        $this->cambiandoRespuesta = false;
        session()->flash('success', __('actividades.declined_success'));
    }

    public function inscribirme(): void
    {
        $userId = Auth::id();

        // Validaciones
        if (! $this->actividad->puedeInscribirse()) {
            $this->addError('error', __('actividades.error_closed'));

            return;
        }

        // Si ya está inscrito con confirmación activa (asiste = true)
        if ($this->miInscripcion && $this->miInscripcion->asiste && ! $this->cambiandoRespuesta) {
            $this->addError('error', __('actividades.error_already_registered'));

            return;
        }

        // Si la actividad es individual y sin coste (ej. concierto, ensayo, reunión)
        if (! $this->actividad->es_de_pago) {
            DB::transaction(function () use ($userId): void {
                if ($this->miInscripcion) {
                    $this->miInscripcion->items()->delete();
                    $this->miInscripcion->update([
                        'asiste' => true,
                        'fecha_inscripcion' => Carbon::now(),
                        'total' => 0.0,
                        'observaciones_alergias' => null,
                        'pagado' => true,
                        'metodo_pago' => 'gratuito',
                    ]);
                    $inscripcion = $this->miInscripcion;
                } else {
                    $inscripcion = ActividadInscripcion::query()->create([
                        'actividad_id' => $this->actividad->id,
                        'user_id' => $userId,
                        'asiste' => true,
                        'fecha_inscripcion' => Carbon::now(),
                        'total' => 0.0,
                        'observaciones_alergias' => null,
                        'pagado' => true,
                        'metodo_pago' => 'gratuito',
                    ]);
                }

                $this->miInscripcion = $inscripcion->fresh(['items.opcion']);
            });

            $this->cambiandoRespuesta = false;
            session()->flash('success', __('actividades.registration_success'));

            return;
        }

        // Actividad con pago y opciones: Filtrar opciones seleccionadas con cantidad > 0
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
        $eraInscritoPrevio = (bool) ($this->miInscripcion && $this->miInscripcion->asiste);

        DB::transaction(function () use ($userId, $totalFinal, $itemsAInsertar, $eraInscritoPrevio): void {
            if ($this->miInscripcion) {
                $dataToUpdate = [
                    'asiste' => true,
                    'total' => $totalFinal,
                    'observaciones_alergias' => $this->actividad->requiereAlergias() ? (trim($this->observaciones_alergias) ?: null) : null,
                ];

                if (! $eraInscritoPrevio) {
                    $dataToUpdate['fecha_inscripcion'] = Carbon::now();
                }

                if ($this->miInscripcion->pagado && round($totalFinal, 2) !== round((float) $this->miInscripcion->total, 2)) {
                    $dataToUpdate['pagado'] = false;
                    $dataToUpdate['metodo_pago'] = null;
                    $dataToUpdate['fecha_pago'] = null;
                }

                $this->miInscripcion->update($dataToUpdate);
                $this->miInscripcion->items()->delete();
                $inscripcion = $this->miInscripcion;
            } else {
                $inscripcion = ActividadInscripcion::query()->create([
                    'actividad_id' => $this->actividad->id,
                    'user_id' => $userId,
                    'asiste' => true,
                    'fecha_inscripcion' => Carbon::now(),
                    'total' => $totalFinal,
                    'observaciones_alergias' => $this->actividad->requiereAlergias() ? (trim($this->observaciones_alergias) ?: null) : null,
                    'pagado' => false,
                ]);
            }

            foreach ($itemsAInsertar as $item) {
                ActividadInscripcionItem::query()->create([
                    'actividad_inscripcion_id' => $inscripcion->id,
                    'actividad_opcion_id' => $item['opcion_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            $this->miInscripcion = $inscripcion->fresh(['items.opcion']);
        });

        $this->cambiandoRespuesta = false;

        $mensaje = $eraInscritoPrevio
            ? __('actividades.registration_updated_success')
            : __('actividades.registration_success');

        session()->flash('success', $mensaje);
    }

    public function render(): View
    {
        return view('livewire.actividades.actividad-detalle');
    }
}
