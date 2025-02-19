<?php

namespace App\Livewire\Comments;

use Livewire\Component;
use App\Models\Comment;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Comments\Forms\UpdateForm;

class CommentEdit extends Component
{
    public ?Comment $comment = null;

    public UpdateForm $form;
    public Collection $comments;

    public function mount(Comment $comment)
    {
        $this->authorize('view-any', Comment::class);

        $this->comment = $comment;

        $this->form->setComment($comment);
        $this->comments = Comment::pluck('created_at', 'id');
    }

    public function save()
    {
        $this->authorize('update', $this->comment);
        $this->validate();
        $this->form->save();
        $this->dispatch('saved');

        return $this->redirect('/comments');        
    }

    public function render()
    {
        return view('livewire.comments.edit', []);
    }
}
