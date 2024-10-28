<?php
namespace App\Livewire\Payment;

use Livewire\Form;
use Livewire\Component;
use App\Models\Payment;
use App\Models\ListasUser;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Dashboard\ListasUsers\Forms\CreateDetailForm;
use App\Livewire\Dashboard\ListasUsers\Forms\UpdateDetailForm;

class PaymentListasUsersDetail extends Component
{
    use WithFileUploads, WithPagination;

    public CreateDetailForm|UpdateDetailForm $form;

    public ?ListasUser $listasUser;
    public Payment $payment;

    public $showingModal = false;

    public $detailListasUsersSearch = '';
    public $detailListasUsersSortField = 'fechaActuacion';
    public $detailListasUsersSortDirection = 'asc';

    public $queryString = [
        'detailListasUsersSearch',
        'detailListasUsersSortField',
        'detailListasUsersSortDirection',
    ];

    public $confirmingListasUserDeletion = false;
    public string $deletingListasUser;

    public function mount()
    {
        $this->form = new CreateDetailForm($this, 'form');
    }

    public function newListasUser()
    {
        $this->form = new CreateDetailForm($this, 'form');
        $this->listasUser = null;

        $this->showModal();
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
    }

    public function confirmListasUserDeletion(string $id)
    {
        $this->deletingListasUser = $id;

        $this->confirmingListasUserDeletion = true;
    }

    public function deleteListasUser(ListasUser $listasUser)
    {
        $this->authorize('delete', $listasUser);

        $listasUser->delete();

        $this->confirmingListasUserDeletion = false;
    }

    public function save()
    {
        if (empty($this->listasUser)) {
            $this->authorize('create', ListasUser::class);
        } else {
            $this->authorize('update', $this->listasUser);
        }

        $this->form->payment_id = $this->payment->id;
        $this->form->save();

        $this->closeModal();
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
                'actuacions.' . $this->detailListasUsersSortField,
                $this->detailListasUsersSortDirection
            )
            ->with('listas.actuacion')
            ->where('actuacions.descripcion', 'like', "%{$this->detailListasUsersSearch}%");;
    }

    public function render()
    {
        return view('livewire.payments.payment-listas-users-detail', [
            'detailListasUsers' => $this->rows,
        ]);
    }
}
