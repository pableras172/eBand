<?php

namespace App\Livewire\Comments;

use Livewire\Component;
use App\Models\Comment;
use Livewire\WithPagination;

class CommentIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'comments.updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingComment;

    public $confirmingDenuncia = false;
    public $denunciaComment;
    public $contenidoComentario='';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingComment = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(Comment $comment)
    {
        $comment->eliminado=$comment->eliminado==0?1:0;
        $comment->update();

        $this->confirmingDeletion = false;
    }

    public function confirmDenuncia(string $id, string $contenido)
    {
        $this->denunciaComment = $id;
        $this->contenidoComentario=$contenido;

        $this->confirmingDenuncia = true;
    }

    public function denuncia(Comment $comment)
    {
        
        $comment->inadecuado=$comment->inadecuado==0?1:0;;
        $comment->update();

        $this->confirmingDenuncia = false;
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
        return Comment::query()
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->with('user')
            ->select('comments.*', 'users.name')
            ->where(function ($query) {
                $query->where('comments.comment', 'like', "%{$this->search}%")
                      ->orWhere('users.name', 'like', "%{$this->search}%"); // Filtro OR por nombre de usuario
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }
    

    public function render()
    {
        return view('livewire.comments.index', [
            'comments' => $this->rows,
        ]);
    }
}
