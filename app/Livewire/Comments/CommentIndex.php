<?php

namespace App\Livewire\Comments;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class CommentIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filter = 'all'; // all, active, flagged, deleted

    public string $sortField = 'comments.created_at';

    public string $sortDirection = 'desc';

    public $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sortField' => ['except' => 'comments.created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public bool $confirmingDeletion = false;

    public ?int $deletingComment = null;

    public bool $confirmingDenuncia = false;

    public ?int $denunciaComment = null;

    public string $contenidoComentario = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function confirmDeletion(int $id): void
    {
        $this->deletingComment = $id;
        $this->confirmingDeletion = true;
    }

    public function delete(?Comment $comment = null): void
    {
        $target = $comment ?? ($this->deletingComment ? Comment::find($this->deletingComment) : null);
        if ($target) {
            $target->eliminado = ! $target->eliminado;
            $target->save();
        }

        $this->confirmingDeletion = false;
        $this->deletingComment = null;
    }

    public function confirmDenuncia(int $id, string $contenido): void
    {
        $this->denunciaComment = $id;
        $this->contenidoComentario = $contenido;
        $this->confirmingDenuncia = true;
    }

    public function denuncia(?Comment $comment = null): void
    {
        $target = $comment ?? ($this->denunciaComment ? Comment::find($this->denunciaComment) : null);
        if ($target) {
            $target->inadecuado = ! $target->inadecuado;
            $target->save();
        }

        $this->confirmingDenuncia = false;
        $this->denunciaComment = null;
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function getCountsProperty(): array
    {
        return [
            'all' => Comment::count(),
            'active' => Comment::where('eliminado', 0)->where('inadecuado', 0)->count(),
            'flagged' => Comment::where('inadecuado', 1)->count(),
            'deleted' => Comment::where('eliminado', 1)->count(),
        ];
    }

    public function getRowsQueryProperty()
    {
        $query = Comment::query()
            ->with(['user', 'actuacion']);

        if ($this->filter === 'active') {
            $query->where('eliminado', 0)->where('inadecuado', 0);
        } elseif ($this->filter === 'flagged') {
            $query->where('inadecuado', 1);
        } elseif ($this->filter === 'deleted') {
            $query->where('eliminado', 1);
        }

        if (! empty($this->search)) {
            $searchTerm = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('comment', 'like', $searchTerm)
                    ->orWhereHas('user', function ($sub) use ($searchTerm) {
                        $sub->where('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('actuacion', function ($sub) use ($searchTerm) {
                        $sub->where('descripcion', 'like', $searchTerm);
                    });
            });
        }

        return $query->orderBy($this->sortField, $this->sortDirection);
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(12);
    }

    public function render()
    {
        return view('livewire.comments.index', [
            'comments' => $this->rows,
            'counts' => $this->counts,
        ]);
    }
}
