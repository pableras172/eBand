<?php

namespace App\Livewire\Dashboard\Comments\Forms;

use Livewire\Form;
use App\Models\Comment;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?Comment $commentario;

    public $comment= '';

    public $user_id = '';

    public $username='';

    public $data = '';

    public $eliminado;

    public $inadecuado;

    public $fechaComentario='';

    public $actuacion='';

    public function rules(): array
    {
        return [
            'comment' => ['required'],
            'user_id' => ['required'],
            'data' => ['required'],
        ];
    }

    public function setComment(Comment $commentario)
    {
        $this->commentario = $commentario;

        $this->comment = $commentario->comment;
        $this->user_id = $commentario->user_id;
        $this->username=$commentario->user->name;
        $this->data = $commentario->data;
        $this->eliminado = $commentario->eliminado;
        $this->inadecuado=$commentario->inadecuado;
        $this->fechaComentario = $commentario->created_at;
        $this->actuacion=$commentario->actuacion->descripcion;
    }

    public function save()
    {
        $this->validate();

        $this->commentario->update();
    }
}
