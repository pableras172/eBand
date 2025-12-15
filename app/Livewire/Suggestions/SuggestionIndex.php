<?php

namespace App\Livewire\Suggestions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SuggestionIndex extends Component
{
    use WithPagination, AuthorizesRequests;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingSuggestion;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingSuggestion = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(Suggestion $suggestion)
    {
        $suggestion->delete();

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
        return Suggestion::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('titulo', 'like', "%{$this->search}%");
    }

    public function render()
    {
        $query = Suggestion::query();

        // If current user is not admin, limit to user's own suggestions
        if (! Gate::allows('admin')) {
            $query->where('iduser', auth()->id());
        }

        // apply search / sorting if existent in your component
        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('titulo', 'like', '%'.$this->search.'%')
                  ->orWhere('texto', 'like', '%'.$this->search.'%');
            });
        }

        // default sorting handling (adjust field names if needed)
        $suggestions = $query
            ->orderBy($this->sortBy ?? 'fechacreacion', $this->sortDirection ?? 'desc')
            ->paginate($this->perPage ?? 10);

        return view('livewire.suggestions.index', compact('suggestions'));
    }
}
