<?php

namespace App\Livewire\Payment;

use App\Livewire\Dashboard\ListasUsers\Forms\CreateDetailForm;
use App\Livewire\Dashboard\ListasUsers\Forms\UpdateDetailForm;
use App\Models\Actuacion;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PaymentListasUsersDetail extends Component
{
    use WithFileUploads, WithPagination;

    public CreateDetailForm|UpdateDetailForm $form;

    public ?ListasUser $listasUser = null;

    public Payment $payment;

    public $showingModal = false;

    // Propiedades para añadir actuación pendiente
    public bool $showingAddModal = false;

    public ?int $selectedActuacionId = null;

    public bool $addWithCoche = false;

    public bool $addWithFurgo = false;

    // Propiedades para editar precios de la actuación y actualizar liquidaciones
    public bool $showingActuacionPriceModal = false;

    public ?int $editingActuacionId = null;

    public string $editingActuacionDescripcion = '';

    public float|string $editingPrecioMusico = '';

    public float|string $editingPrecioCoche = '';

    public float|string $editingPrecioFurgona = '';

    public int $editingActuacionPagosCount = 0;

    public ?int $editingListasUserId = null;

    public bool $editingMusicoCoche = false;

    public bool $editingMusicoFurgona = false;

    public $detailListasUsersSearch = '';

    public $detailListasUsersSortField = 'fechaActuacion';

    public $detailListasUsersSortDirection = 'asc';

    public $queryString = [
        'detailListasUsersSearch',
        'detailListasUsersSortField',
        'detailListasUsersSortDirection',
    ];

    public $confirmingListasUserDeletion = false;

    public string $deletingListasUser = '';

    public function mount()
    {
        $this->form = new CreateDetailForm($this, 'form');
    }

    public function editListasUser(ListasUser $listasUser)
    {
        $this->form = new UpdateDetailForm($this, 'form');
        $this->form->setListasUser($listasUser);
        $this->listasUser = $listasUser;

        $this->showModal();
    }

    public function showModal()
    {
        $this->showingModal = true;
    }

    public function closeModal()
    {
        $this->showingModal = false;
        $this->listasUser = null;
    }

    public function openAddModal()
    {
        $this->selectedActuacionId = null;
        $this->addWithCoche = false;
        $this->addWithFurgo = false;
        $this->showingAddModal = true;
    }

    public function closeAddModal()
    {
        $this->showingAddModal = false;
        $this->selectedActuacionId = null;
    }

    public function openActuacionPriceModal(int $actuacionId, ?int $listasUserId = null): void
    {
        $this->authorize('update', $this->payment);

        $actuacion = Actuacion::with(['lista', 'listas'])->findOrFail($actuacionId);

        $this->editingActuacionId = $actuacion->id;
        $this->editingActuacionDescripcion = $actuacion->descripcion;
        $this->editingPrecioMusico = (float) $actuacion->preciomusico;
        $this->editingPrecioCoche = (float) $actuacion->preciocoche;
        $this->editingPrecioFurgona = (float) $actuacion->preciofurgona;

        $this->editingListasUserId = $listasUserId;
        if ($listasUserId) {
            $lu = ListasUser::find($listasUserId);
            $this->editingMusicoCoche = (bool) $lu?->coche;
            $this->editingMusicoFurgona = (bool) $lu?->furgona;
        } else {
            $this->editingMusicoCoche = false;
            $this->editingMusicoFurgona = false;
        }

        // Calcular cuántos pagos distintos se verán actualizados
        $listaIds = $actuacion->listas->isNotEmpty()
            ? $actuacion->listas->pluck('id')
            : collect([$actuacion->lista?->id])->filter();

        $this->editingActuacionPagosCount = $listaIds->isNotEmpty()
            ? ListasUser::whereIn('listas_id', $listaIds)
                ->whereNotNull('payment_id')
                ->distinct('payment_id')
                ->count('payment_id')
            : 0;

        $this->showingActuacionPriceModal = true;
    }

    public function closeActuacionPriceModal(): void
    {
        $this->showingActuacionPriceModal = false;
        $this->editingActuacionId = null;
        $this->editingListasUserId = null;
    }

    public function saveActuacionPrices(): void
    {
        $this->authorize('update', $this->payment);

        $this->validate([
            'editingPrecioMusico' => 'required|numeric|min:0',
            'editingPrecioCoche' => 'required|numeric|min:0',
            'editingPrecioFurgona' => 'required|numeric|min:0',
        ]);

        $actuacion = Actuacion::with(['lista', 'listas'])->findOrFail($this->editingActuacionId);
        $actuacion->preciomusico = (float) $this->editingPrecioMusico;
        $actuacion->preciocoche = (float) $this->editingPrecioCoche;
        $actuacion->preciofurgona = (float) $this->editingPrecioFurgona;
        $actuacion->save();

        // Si se abrió para una línea concreta de este músico, sincronizar su asignación de coche/furgona
        if ($this->editingListasUserId) {
            $currentRow = ListasUser::find($this->editingListasUserId);
            if ($currentRow) {
                $currentRow->coche = (bool) $this->editingMusicoCoche;
                $currentRow->furgona = (bool) $this->editingMusicoFurgona;
                $currentRow->save();
            }
        }

        // Obtener todos los ListasUser asociados a esta actuación que estén en pagos
        $listaIds = $actuacion->listas->isNotEmpty()
            ? $actuacion->listas->pluck('id')
            : collect([$actuacion->lista?->id])->filter();

        $listasUsers = $listaIds->isNotEmpty()
            ? ListasUser::whereIn('listas_id', $listaIds)
                ->whereNotNull('payment_id')
                ->with(['user', 'listas.actuacion'])
                ->get()
            : collect();

        $affectedPaymentIds = [];

        foreach ($listasUsers as $lu) {
            $this->calcularTotalesListasUser($lu, $actuacion);
            $affectedPaymentIds[] = $lu->payment_id;
        }

        // Recalcular cada uno de los pagos afectados
        $uniquePaymentIds = array_unique(array_filter($affectedPaymentIds));
        foreach ($uniquePaymentIds as $pId) {
            $p = Payment::find($pId);
            if ($p) {
                $p->totalPago = (float) ListasUser::where('payment_id', $p->id)->sum('totalActo');
                $p->save();
            }
        }

        // Refrescar el pago actual en Livewire
        $this->payment->refresh();
        $this->dispatch('refresh-payment');

        $this->closeActuacionPriceModal();
        $this->dispatch('actuacion-prices-updated', count: count($uniquePaymentIds));
    }

    public function confirmListasUserDeletion(string $id)
    {
        $this->deletingListasUser = $id;
        $this->confirmingListasUserDeletion = true;
    }

    public function deleteListasUser(ListasUser $listasUser)
    {
        $this->authorize('update', $this->payment);

        $listasUser->delete();

        $this->recalcularTotalPago();

        $this->confirmingListasUserDeletion = false;
        $this->dispatch('listas-user-deleted');
    }

    public function save()
    {
        if (! $this->listasUser) {
            return;
        }

        $this->authorize('update', $this->payment);

        $this->listasUser->coche = (bool) $this->form->coche;
        $this->listasUser->furgona = (bool) $this->form->furgona;
        $this->listasUser->pagada = (bool) $this->form->pagada;
        $this->listasUser->cuentas = (bool) $this->form->cuentas;
        $this->listasUser->disponible = (bool) $this->form->disponible;
        $this->listasUser->save();

        $this->calcularTotalesListasUser($this->listasUser);
        $this->recalcularTotalPago();

        $this->closeModal();
        $this->dispatch('listas-user-updated');
    }

    public function addActuacion()
    {
        $this->authorize('update', $this->payment);

        $this->validate([
            'selectedActuacionId' => 'required|exists:actuacions,id',
        ]);

        $actuacion = Actuacion::findOrFail($this->selectedActuacionId);

        // Asegurar que la actuación tenga lista
        $lista = $actuacion->lista;
        if (! $lista) {
            $lista = Listas::create([
                'actuacions_id' => $actuacion->id,
                'pagada' => 1,
                'cuentas' => 1,
            ]);
        }

        // Buscar si ya existía listas_user para este usuario
        $listaUser = ListasUser::firstOrNew([
            'listas_id' => $lista->id,
            'user_id' => $this->payment->users_id,
        ]);

        $listaUser->payment_id = $this->payment->id;
        $listaUser->disponible = true;
        $listaUser->coche = $this->addWithCoche;
        $listaUser->furgona = $this->addWithFurgo;
        $listaUser->pagada = true;
        $listaUser->cuentas = true;
        $listaUser->save();

        $this->calcularTotalesListasUser($listaUser);
        $this->recalcularTotalPago();

        $this->closeAddModal();
        $this->dispatch('actuacion-added');
    }

    public function calcularTotalesListasUser(ListasUser $listaUser, ?Actuacion $actuacion = null): void
    {
        $actuacion = $actuacion ?? $listaUser->listas?->actuacion;
        $user = $listaUser->user ?? $this->payment->user;

        if (! $actuacion || ! $user) {
            return;
        }

        $porcentaje = 1.0;
        if ($actuacion->aplicaporcentaje) {
            $porcentaje = ! empty($actuacion->porcentajepersonal) && $actuacion->porcentajepersonal > 0
                ? $actuacion->porcentajepersonal / 100
                : ($user->porcentaje > 0 ? $user->porcentaje / 100 : 1.0);
        }

        $totalActuacion = (float) $actuacion->preciomusico * $porcentaje;
        $totalCoche = (float) $actuacion->preciocoche * ($listaUser->coche ? 1 : 0);
        $totalFurgo = (float) $actuacion->preciofurgona * ($listaUser->furgona ? 1 : 0);
        $totalActo = $totalActuacion + $totalCoche + $totalFurgo;

        $listaUser->totalActuacion = $totalActuacion;
        $listaUser->totalCoche = $totalCoche;
        $listaUser->totalFurgo = $totalFurgo;
        $listaUser->totalActo = $totalActo;
        $listaUser->cuentas = true;
        $listaUser->pagada = true;
        $listaUser->save();
    }

    public function recalcularTotalPago(): void
    {
        $total = ListasUser::where('payment_id', $this->payment->id)->sum('totalActo');
        $this->payment->totalPago = (float) $total;
        $this->payment->save();

        $this->dispatch('refresh-payment');
    }

    public function getAvailableActuacionesProperty(): Collection
    {
        // IDs de actuaciones que ya están en este pago
        $alreadyInPaymentActuacionIds = ListasUser::where('payment_id', $this->payment->id)
            ->join('listas', 'listas_user.listas_id', '=', 'listas.id')
            ->pluck('listas.actuacions_id')
            ->toArray();

        return Actuacion::whereNotIn('id', $alreadyInPaymentActuacionIds)
            ->where('noaplicapago', 0)
            ->orderBy('fechaActuacion', 'desc')
            ->take(25)
            ->get();
    }

    public function sortBy($field)
    {
        if ($this->detailListasUsersSortField === $field) {
            $this->detailListasUsersSortDirection =
                $this->detailListasUsersSortDirection === 'asc'
                    ? 'desc'
                    : 'asc';
        } else {
            $this->detailListasUsersSortDirection = 'asc';
        }

        $this->detailListasUsersSortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return ListasUser::where('payment_id', $this->payment->id)
            ->join('listas', 'listas_user.listas_id', '=', 'listas.id')
            ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
            ->select('listas_user.*', 'actuacions.fechaActuacion')
            ->orderBy(
                'actuacions.'.$this->detailListasUsersSortField,
                $this->detailListasUsersSortDirection
            )
            ->with('listas.actuacion')
            ->where('actuacions.descripcion', 'like', "%{$this->detailListasUsersSearch}%");
    }

    public function render()
    {
        return view('livewire.payments.payment-listas-users-detail', [
            'detailListasUsers' => $this->rows,
            'availableActuaciones' => $this->availableActuaciones,
        ]);
    }
}
