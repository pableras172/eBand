<?php

namespace App\Livewire\Actuaciones;

use App\Models\Actuacion;
use App\Models\Contratos;
use App\Models\Tipoactuacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ContratoActuaciones extends Component
{
    use WithPagination;

    public Contratos $contrato;

    public string $search = '';

    public bool $showFormModal = false;

    public bool $isEditing = false;

    public ?int $actuacionId = null;

    public string $fechaActuacion = '';

    public string $descripcion = '';

    public ?int $tipoactuacions_id = null;

    public ?int $coches = null;

    public ?float $preciocoche = null;

    public ?int $musicos = null;

    public ?float $preciomusico = null;

    public string $observaciones = '';

    public bool $pagado = false;

    public bool $aplicaporcentaje = true;

    public bool $noaplicapago = false;

    public bool $visible = true;

    public bool $oficial = false;

    public bool $is_draft = false;

    public ?float $porcentajepersonal = null;

    public function mount(Contratos $contrato): void
    {
        abort_if(Gate::denies('admin_access'), 403, '403 Forbidden');

        $this->contrato = $contrato;

        $editActuacionId = request()->integer('edit');

        if ($editActuacionId > 0) {
            $this->openEditModal($editActuacionId);
        }
    }

    protected function rules(): array
    {
        return [
            'fechaActuacion' => ['required', 'date'],
            'descripcion' => ['required', 'string'],
            'tipoactuacions_id' => ['required', 'exists:tipoactuacions,id'],
            'coches' => ['nullable', 'integer', 'min:0'],
            'preciocoche' => ['nullable', 'numeric', 'min:0'],
            'musicos' => ['nullable', 'integer', 'min:0'],
            'preciomusico' => ['nullable', 'numeric', 'min:0'],
            'observaciones' => ['nullable', 'string'],
            'pagado' => ['boolean'],
            'aplicaporcentaje' => ['boolean'],
            'noaplicapago' => ['boolean'],
            'visible' => ['boolean'],
            'oficial' => ['boolean'],
            'is_draft' => ['boolean'],
            'porcentajepersonal' => ['nullable', 'numeric'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {

        Log::error('Opening create modal for Contrato ID: '.$this->contrato->id);
        $this->resetValidation();
        $this->resetForm();
        $this->isEditing = false;
        $this->showFormModal = true;
    }

    public function openEditModal(int $actuacionId): void
    {
        Log::error('Opening edit modal for Actuacion ID: '.$actuacionId.' and Contrato ID: '.$this->contrato->id);
        $this->resetValidation();

        $actuacion = Actuacion::query()
            ->where('contratos_id', $this->contrato->id)
            ->findOrFail($actuacionId);

        $this->actuacionId = $actuacion->id;
        $this->fechaActuacion = Carbon::parse($actuacion->fechaActuacion)->format('Y-m-d');
        $this->descripcion = (string) $actuacion->descripcion;
        $this->tipoactuacions_id = $actuacion->tipoactuacions_id;
        $this->coches = $actuacion->coches;
        $this->preciocoche = $actuacion->preciocoche !== null ? (float) $actuacion->preciocoche : null;
        $this->musicos = $actuacion->musicos;
        $this->preciomusico = $actuacion->preciomusico !== null ? (float) $actuacion->preciomusico : null;
        $this->observaciones = (string) ($actuacion->observaciones ?? '');
        $this->pagado = (bool) $actuacion->pagado;
        $this->aplicaporcentaje = (bool) $actuacion->aplicaporcentaje;
        $this->noaplicapago = (bool) $actuacion->noaplicapago;
        $this->visible = (bool) $actuacion->visible;
        $this->oficial = (bool) $actuacion->oficial;
        $this->is_draft = (bool) $actuacion->is_draft;
        $this->porcentajepersonal = $actuacion->porcentajepersonal !== null ? (float) $actuacion->porcentajepersonal : null;

        $this->isEditing = true;
        $this->showFormModal = true;
    }

    public function closeModal(): void
    {
        $this->showFormModal = false;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->isEditing && $this->actuacionId !== null) {
            $actuacion = Actuacion::query()
                ->where('contratos_id', $this->contrato->id)
                ->findOrFail($this->actuacionId);
        } else {
            $actuacion = new Actuacion;
            $actuacion->contratos_id = $this->contrato->id;
        }

        $actuacion->fechaActuacion = $validated['fechaActuacion'];
        $actuacion->descripcion = $validated['descripcion'];
        $actuacion->tipoactuacions_id = $validated['tipoactuacions_id'];
        $actuacion->coches = $validated['coches'];
        $actuacion->preciocoche = $validated['preciocoche'];
        $actuacion->musicos = $validated['musicos'];
        $actuacion->preciomusico = $validated['preciomusico'];
        $actuacion->observaciones = $validated['observaciones'];
        $actuacion->pagado = $validated['pagado'];
        $actuacion->aplicaporcentaje = $validated['aplicaporcentaje'];
        $actuacion->noaplicapago = $validated['noaplicapago'];
        $actuacion->visible = $validated['visible'];
        $actuacion->oficial = $validated['oficial'];
        $actuacion->is_draft = $validated['is_draft'];
        $actuacion->porcentajepersonal = $validated['porcentajepersonal'];

        $actuacion->save();

        $actuacion->calendar = $this->generateICSFile($actuacion);
        $actuacion->save();

        $this->closeModal();
        $this->resetForm();

        session()->flash('success', $this->isEditing
            ? __('Actuación actualizada correctamente.')
            : __('Actuación creada correctamente.'));
    }

    protected function resetForm(): void
    {
        $this->actuacionId = null;
        $this->fechaActuacion = '';
        $this->descripcion = '';
        $this->tipoactuacions_id = null;
        $this->coches = null;
        $this->preciocoche = null;
        $this->musicos = null;
        $this->preciomusico = null;
        $this->observaciones = '';
        $this->pagado = false;
        $this->aplicaporcentaje = true;
        $this->noaplicapago = false;
        $this->visible = true;
        $this->oficial = false;
        $this->is_draft = false;
        $this->porcentajepersonal = null;
    }

    protected function generateICSFile(Actuacion $evento): string
    {
        $content = "BEGIN:VCALENDAR\r\n";
        $content .= "VERSION:2.0\r\n";
        $content .= "PRODID:-//eBand\r\n";
        $content .= "BEGIN:VEVENT\r\n";
        $content .= 'UID:'.uniqid()."\r\n";
        $content .= 'DTSTAMP;VALUE=DATE-TIME:'.Carbon::now()->format('Ymd\\THis')."\r\n";
        $content .= 'DTSTART;VALUE=DATE-TIME:'.Carbon::parse($evento->fechaActuacion)->format('Ymd\\THis')."\r\n";
        $content .= 'DTEND;VALUE=DATE-TIME:'.Carbon::parse($evento->fechaActuacion)->format('Ymd\\THis')."\r\n";
        $content .= 'SUMMARY:'.Config::get('app.banda', 'eBand').' - '.$evento->descripcion."\r\n";
        $content .= 'DESCRIPTION:'.($evento->observaciones ?? '').' - '.Config::get('app.url').'/actuacion/'.$evento->id." \r\n";
        $content .= "END:VEVENT\r\n";
        $content .= "END:VCALENDAR\r\n";

        $newFileName = 'event_'.time().'.ics';
        Storage::put('eventos/'.$newFileName, $content);

        return $newFileName;
    }

    public function render()
    {
        $actuaciones = Actuacion::query()
            ->with(['tipoactuacion', 'lista'])
            ->where('contratos_id', $this->contrato->id)
            ->when($this->search !== '', function ($query) {
                $query->where(function ($nestedQuery) {
                    $nestedQuery->where('descripcion', 'like', '%'.$this->search.'%')
                        ->orWhereDate('fechaActuacion', $this->search)
                        ->orWhereHas('tipoactuacion', function ($typeQuery) {
                            $typeQuery->where('nombre', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy('fechaActuacion', 'asc')
            ->paginate(10);

        $tiposActuacion = Tipoactuacion::query()->orderBy('nombre')->get();

        return view('livewire.actuaciones.contrato-actuaciones', [
            'actuaciones' => $actuaciones,
            'tiposActuacion' => $tiposActuacion,
        ]);
    }
}
