<?php

namespace App\Livewire\Comments;

use Livewire\Component;
use App\Models\Comment;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Comments\Forms\CreateForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;
    public Collection $comments;

    public function mount()
    {
        $this->comments = Comment::pluck('created_at', 'id');
    }

    public function save()
    {
        $this->authorize('create', Comment::class);

        $this->validate();

        $comment = $this->form->save();

        return redirect()->route('dashboard.comments.edit', $comment);
    }

    public function render()
    {
        return view('livewire.comments.create', []);
    }

    public function store(Request $request)
{
    $request->validate([
        'comment' => 'required|string|max:200',
        'actuacion_id' => 'required|exists:actuacions,id'
    ]);

    $comment = Comment::create([
        'comment' => $request->comment,
        'user_id' => Auth::id(),
        'data'=>'{}',
        'actuacion_id' => $request->actuacion_id,
        'created_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'comment' => $comment->comment,
        'created_at' => $comment->created_at->format('d/m/Y H:i'),
    ]);
}
}
