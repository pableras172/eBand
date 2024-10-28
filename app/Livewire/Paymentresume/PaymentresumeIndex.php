<?php

namespace App\Livewire\Paymentresume;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Paymentresume;

class PaymentresumeIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingPaymetresume;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingPaymetresume = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(Paymentresume $paymentresume)
    {
        $paymentresume->delete();

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
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return Paymentresume::query()
            ->orderBy($this->sortField, $this->sortDirection)           
            ->join('users', 'paymentresume.user_id', '=', 'users.id')
            ->with('user')
            ->orderBy($this->sortField, $this->sortDirection)            
            ->where(function($query) {
                $query->where('users.name', 'like', "%{$this->search}%")
                      ->orWhere('paymentresume.descripcion', 'like', "%{$this->search}%");
            }) 
            ->select('paymentresume.*');
    }

    public function render()
    {
        return view('livewire.payments.paymentresumes.index', [
            'paymentresumes' => $this->rows,
        ]);
    }
}
