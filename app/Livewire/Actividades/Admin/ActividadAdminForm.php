<?php

declare(strict_types=1);

namespace App\Livewire\Actividades\Admin;

use App\Models\Actividad;
use App\Models\ActividadOpcion;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ActividadAdminForm extends Component
{
    public ?Actividad $actividad = null;

    public bool $isEditing = false;

    public string $titulo = '';

    public string $tipo = 'comida';

    public bool $es_de_pago = true;

    public string $descripcion = '';

    public string $lugar = '';

    public string $fecha = '';

    public string $fecha_limite_inscripcion = '';

    public string $estado = 'borrador';

    public string $instrucciones_pago = '';

    /**
     * @var array<int, array{id: ?int, titulo: string, descripcion: string, precio: string|float, orden: int}>
     */
    public array $opciones = [];

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        $rules = [
            'titulo' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'string', 'in:comida,cena,excursion,concierto,reunion,otro'],
            'es_de_pago' => ['required', 'boolean'],
            'descripcion' => ['nullable', 'string'],
            'lugar' => ['nullable', 'string', 'max:255'],
            'fecha' => ['required', 'date'],
            'fecha_limite_inscripcion' => ['required', 'date', 'before_or_equal:fecha'],
            'estado' => ['required', 'string', 'in:borrador,abierta,cerrada'],
            'instrucciones_pago' => ['nullable', 'string'],
        ];

        if ($this->es_de_pago) {
            $rules['opciones'] = ['required', 'array', 'min:1'];
            $rules['opciones.*.titulo'] = ['required', 'string', 'max:255'];
            $rules['opciones.*.descripcion'] = ['nullable', 'string'];
            $rules['opciones.*.precio'] = ['required', 'numeric', 'min:0'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'fecha_limite_inscripcion' => 'fecha límite de inscripción',
            'instrucciones_pago' => 'instrucciones de pago',
            'opciones.*.titulo' => 'título de la opción',
            'opciones.*.precio' => 'precio de la opción',
        ];
    }

    public function mount(?int $actividadId = null): void
    {
        abort_if(! Gate::allows('admin'), 403, 'No autorizado para gestionar actividades.');

        if ($actividadId) {
            $this->actividad = Actividad::query()->with('opciones')->findOrFail($actividadId);
            $this->isEditing = true;

            $this->titulo = $this->actividad->titulo;
            $this->tipo = $this->actividad->tipo;
            $this->es_de_pago = (bool) ($this->actividad->es_de_pago ?? true);
            $this->descripcion = (string) $this->actividad->descripcion;
            $this->lugar = (string) $this->actividad->lugar;
            $this->fecha = $this->actividad->fecha ? $this->actividad->fecha->format('Y-m-d\TH:i') : '';
            $this->fecha_limite_inscripcion = $this->actividad->fecha_limite_inscripcion
                ? $this->actividad->fecha_limite_inscripcion->format('Y-m-d\TH:i')
                : '';
            $this->estado = $this->actividad->estado;
            $this->instrucciones_pago = (string) $this->actividad->instrucciones_pago;

            foreach ($this->actividad->opciones as $index => $opcion) {
                $this->opciones[] = [
                    'id' => $opcion->id,
                    'titulo' => $opcion->titulo,
                    'descripcion' => (string) $opcion->descripcion,
                    'precio' => (float) $opcion->precio,
                    'orden' => $opcion->orden ?? $index,
                ];
            }
        } else {
            $this->fecha = Carbon::now()->addDays(14)->setTime(14, 0)->format('Y-m-d\TH:i');
            $this->fecha_limite_inscripcion = Carbon::now()->addDays(10)->setTime(23, 59)->format('Y-m-d\TH:i');
            // Opción por defecto
            $this->opciones[] = [
                'id' => null,
                'titulo' => 'Menú General',
                'descripcion' => '',
                'precio' => 0.00,
                'orden' => 0,
            ];
        }
    }

    public function setEsDePago(bool $value): void
    {
        $this->es_de_pago = $value;
    }

    public function addOpcion(): void
    {
        $this->opciones[] = [
            'id' => null,
            'titulo' => '',
            'descripcion' => '',
            'precio' => 0.00,
            'orden' => count($this->opciones),
        ];
    }

    public function removeOpcion(int $index): void
    {
        if (count($this->opciones) <= 1) {
            $this->addError('opciones', 'Debe haber al menos una opción configurada.');

            return;
        }

        unset($this->opciones[$index]);
        $this->opciones = array_values($this->opciones);
    }

    public function save(): mixed
    {
        abort_if(! Gate::allows('admin'), 403);

        $this->validate();

        DB::transaction(function (): void {
            $data = [
                'titulo' => $this->titulo,
                'tipo' => $this->tipo,
                'es_de_pago' => $this->es_de_pago,
                'descripcion' => $this->descripcion ?: null,
                'lugar' => $this->lugar ?: null,
                'fecha' => $this->fecha,
                'fecha_limite_inscripcion' => $this->fecha_limite_inscripcion,
                'estado' => $this->estado,
                'instrucciones_pago' => $this->es_de_pago ? ($this->instrucciones_pago ?: null) : null,
            ];

            if ($this->isEditing && $this->actividad) {
                $this->actividad->update($data);
                $actividad = $this->actividad;
            } else {
                $actividad = Actividad::query()->create($data);
            }

            if (! $this->es_de_pago) {
                // Eliminar opciones huérfanas si la actividad pasó a ser individual sin precio
                ActividadOpcion::query()
                    ->where('actividad_id', $actividad->id)
                    ->doesntHave('inscripcionItems')
                    ->delete();
            } else {
                // Guardar opciones
                $keptIds = [];
                foreach ($this->opciones as $index => $opcionData) {
                    if (! empty($opcionData['id'])) {
                        $opcion = ActividadOpcion::query()
                            ->where('actividad_id', $actividad->id)
                            ->find($opcionData['id']);

                        if ($opcion) {
                            $opcion->update([
                                'titulo' => $opcionData['titulo'],
                                'descripcion' => $opcionData['descripcion'] ?: null,
                                'precio' => (float) $opcionData['precio'],
                                'orden' => $index,
                            ]);
                            $keptIds[] = $opcion->id;
                        }
                    } else {
                        $newOpcion = ActividadOpcion::query()->create([
                            'actividad_id' => $actividad->id,
                            'titulo' => $opcionData['titulo'],
                            'descripcion' => $opcionData['descripcion'] ?: null,
                            'precio' => (float) $opcionData['precio'],
                            'orden' => $index,
                        ]);
                        $keptIds[] = $newOpcion->id;
                    }
                }

                // Opciones eliminadas que no tengan ítems asociados
                ActividadOpcion::query()
                    ->where('actividad_id', $actividad->id)
                    ->whereNotIn('id', $keptIds)
                    ->doesntHave('inscripcionItems')
                    ->delete();
            }
        });

        session()->flash('success', $this->isEditing ? __('actividades.activity_updated') : __('actividades.activity_created'));

        return redirect()->route('admin.actividades.index');
    }

    public function render(): View
    {
        return view('livewire.actividades.admin.actividad-admin-form');
    }
}
