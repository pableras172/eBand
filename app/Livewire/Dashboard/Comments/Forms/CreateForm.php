<?php

namespace App\Livewire\Dashboard\Comments\Forms;

use Livewire\Form;
use App\Models\Comment;
use Livewire\Attributes\Rule;

class CreateForm extends Form
{
    #[Rule('required')]
    public $comment = '';

    #[Rule('required')]
    public $user_id = '';

    #[Rule('required')]
    public $data = '';

    public function save()
    {
        $this->validate();

        $comment = Comment::create($this->except([]));

        $this->reset();

        return $comment;
    }
}
