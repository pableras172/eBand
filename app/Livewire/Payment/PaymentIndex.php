<?php

namespace App\Livewire\Payment;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentIndex extends Component
{
    use WithPagination;

    public $search;

    public $sortField = 'fechaPago';

    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;

    public $deletingPayment;

    public $deletingPaymentDescription;

    public $user;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /*public function mount(User $user)
    {
        $this->user = $user ?: Auth::user();

        if (!Auth::user()->hasRole('Admin') && $this->user->id !== Auth::id()) {
            abort(403, __('Sorry! You are not authorized to perform this action.'));
        }
    }*/
    public function mount(?User $user = null)
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        if (! $authUser) {
            abort(401);
        }

        $targetUser = ($user && $user->exists) ? $user : null;

        if ($authUser->hasRole('Admin')) {
            $this->user = $targetUser;
        } else {
            if ($targetUser) {
                $esPropio = $targetUser->id === $authUser->id;
                $esPadreDelUser = $authUser->hijos->contains('id', $targetUser->id);

                if (! $esPropio && ! $esPadreDelUser) {
                    abort(403, __('Sorry! You are not authorized to perform this action.'));
                }
                $this->user = $targetUser;
            } else {
                $this->user = $authUser;
            }
        }

        $this->authorize('viewAny', [Payment::class, $this->user]);
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingPayment = $id;

        $payment = Payment::find($id);
        if ($payment) {
            $this->deletingPaymentDescription = $payment->descripcion;
        } else {
            $this->deletingPaymentDescription = null;
        }

        $this->confirmingDeletion = true;
    }

    public function delete(Payment $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();

        $this->confirmingDeletion = false;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection =
                $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(10);
    }

    public function getRowsQueryProperty()
    {
        $query = Payment::query()
            ->join('users', 'payment.users_id', '=', 'users.id')
            ->with('user')
            ->orderBy($this->sortField, $this->sortDirection)
            ->where(function ($q) {
                $q->where('users.name', 'like', "%{$this->search}%")
                    ->orWhere('payment.descripcion', 'like', "%{$this->search}%");
            })
            ->select('payment.*');

        if ($this->user && $this->user->id) {
            $query->where('payment.users_id', $this->user->id);
        }

        return $query;
    }

    public function render()
    {
        return view('livewire.payments.index', [
            'payments' => $this->rows,
        ]);
    }
}
