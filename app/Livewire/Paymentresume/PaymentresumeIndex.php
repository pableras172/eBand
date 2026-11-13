<?php

namespace App\Livewire\Paymentresume;

use App\Models\Paymentresume;
use Livewire\Component;
use Livewire\WithPagination;

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
        return $this->rowsQuery->paginate(10);
    }

    public function getRowsQueryProperty()
    {
        $direction = in_array(strtolower($this->sortDirection), ['asc', 'desc']) ? $this->sortDirection : 'desc';

        return Paymentresume::query()
            ->with('user')
            ->withCount('payments')
            ->withSum('payments', 'totalPago')
            ->leftJoin('users', 'paymentresume.user_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users.name', 'like', "%{$this->search}%")
                    ->orWhere('paymentresume.descripcion', 'like', "%{$this->search}%");
            })
            ->select('paymentresume.*')
            ->orderBy($this->sortField === 'user_id' ? 'users.name' : 'paymentresume.'.$this->sortField, $direction);
    }

    public function render()
    {
        return view('livewire.payments.paymentresumes.index', [
            'paymentresumes' => $this->rows,
        ]);
    }
}
