<?php

namespace App\Livewire\Paymentresume;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Payment;
use App\Models\Paymentresume;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Livewire\Dashboard\Paymentresumes\Forms\CreateDetailForm;
use App\Livewire\Dashboard\Paymentresumes\Forms\UpdateDetailForm;

class PaymentresumePaymentsDetail extends Component
{
    use WithFileUploads, WithPagination;

    public CreateDetailForm|UpdateDetailForm $form;

    public ?Payment $payment = null;
    public Paymentresume $paymetresume;

    public $showingModal = false;

    public $detailPaymentsSearch = '';
    public $detailPaymentsSortField = 'updated_at';
    public $detailPaymentsSortDirection = 'desc';

    public $queryString = [
        'detailPaymentsSearch',
        'detailPaymentsSortField',
        'detailPaymentsSortDirection',
    ];

    public $confirmingPaymentDeletion = false;
    public string $deletingPayment = '';

    public function mount(Paymentresume $paymetresume)
    {
        $this->form = new CreateDetailForm($this, 'form');
        $this->paymetresume = $paymetresume;
    }

    public function newPayment()
    {
        $this->form = new CreateDetailForm($this, 'form');
        $this->payment = null;

        $this->showModal();
    }

    public function editPayment(Payment $payment)
    {
        $this->form = new UpdateDetailForm($this, 'form');
        $this->form->setPayment($payment);
        $this->payment = $payment;

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

    public function confirmPaymentDeletion(string $id)
    {
        $this->deletingPayment = $id;
        $this->confirmingPaymentDeletion = true;
    }

    public function deletePayment(Payment $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();

        $this->confirmingPaymentDeletion = false;
    }

    public function save()
    {
        if (empty($this->payment)) {
            $this->authorize('create', Payment::class);
        } else {
            $this->authorize('update', $this->payment);
        }

        try {
            $this->form->paymentresume_id = $this->paymetresume->id;
            $this->form->save();

            $this->closeModal();
            session()->flash('success', __('common.pagocreado'));
        } catch (\Exception $e) {
            Log::error('Error saving payment: ', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
            session()->flash('error', __('common.errorpago'));
        }
    }

    public function sortBy($field)
    {
        if ($this->detailPaymentsSortField === $field) {
            $this->detailPaymentsSortDirection =
                $this->detailPaymentsSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->detailPaymentsSortDirection = 'asc';
        }

        $this->detailPaymentsSortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return $this->paymetresume
            ->payments()
            ->orderBy(
                $this->detailPaymentsSortField,
                $this->detailPaymentsSortDirection
            )
            ->where('descripcion', 'like', "%{$this->detailPaymentsSearch}%");
    }

    public function render()
    {
        return view('livewire.payments.paymentresumes.payments-detail', [
            'detailPayments' => $this->rows,
        ]);
    }
}
