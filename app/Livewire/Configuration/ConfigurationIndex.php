<?php

namespace App\Livewire\Configuration;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Configuration;

class ConfigurationIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'param';
    public $sortDirection = 'asc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingConfiguration;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingConfiguration = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(Configuration $configuration)
    {
        $configuration->delete();

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
        return Configuration::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('param', 'like', "%{$this->search}%");
    }

    public function render()
    {
        return view('livewire.configurations.index', [
            'configurations' => $this->rows,
        ]);
    }
}
