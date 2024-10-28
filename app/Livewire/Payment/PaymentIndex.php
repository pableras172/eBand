<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use App\Models\Payment;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

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
    public function mount(User $user)
    {
        $this->user = $user ?: Auth::user();

        if (!Auth::user()->hasRole('Admin') && $this->user->id !== Auth::id()) {
            abort(403, __('Sorry! You are not authorized to perform this action.'));
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
        $this->authorize('delete', $user,$payment);            
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
        if($this->user!=null && $this->user->id!=null){
            return Payment::query()
            ->join('users', 'payment.users_id', '=', 'users.id')
            ->with('user')
            ->where('payment.users_id', $this->user->id)
            ->orderBy($this->sortField, $this->sortDirection)
            ->where(function($query) {
                $query->where('users.name', 'like', "%{$this->search}%")
                      ->orWhere('payment.descripcion', 'like', "%{$this->search}%");
            })
            ->select('payment.*');
        }else{
            return Payment::query()
            ->join('users', 'payment.users_id', '=', 'users.id')
            ->with('user')
            ->orderBy($this->sortField, $this->sortDirection)
            ->where(function($query) {
                $query->where('users.name', 'like', "%{$this->search}%")
                      ->orWhere('payment.descripcion', 'like', "%{$this->search}%");
            })
            ->select('payment.*');
        }
        
    }
    
    

    public function render()
    {
        return view('livewire.payments.index', [
            'payments' => $this->rows,
        ]);
    }
}
