<?php

namespace App\Livewire\Dashboard\Comments\Forms;

use App\Models\Comment;
use Livewire\Form;

class UpdateForm extends Form
{
    public ?Comment $commentario;

    public $comment = '';

    public $user_id = '';

    public $username = '';

    public $data = '';

    public $eliminado;

    public $inadecuado;

    public $fechaComentario = '';

    public $actuacion = '';

    public function rules(): array
    {
        return [
            'comment' => ['required', 'string'],
        ];
    }

    public function setComment(Comment $commentario)
    {
        $this->commentario = $commentario;

        $this->comment = $commentario->comment;
        $this->user_id = $commentario->user_id;
        $this->username = optional($commentario->user)->name ?? 'Usuari';
        $this->data = $commentario->data;
        $this->eliminado = (bool) $commentario->eliminado;
        $this->inadecuado = (bool) $commentario->inadecuado;
        $this->fechaComentario = $commentario->created_at;
        $this->actuacion = optional($commentario->actuacion)->descripcion ?? '-';
    }

    public function save()
    {
        $this->validate();

        $this->commentario->update([
            'comment' => $this->comment,
            'eliminado' => (bool) $this->eliminado,
            'inadecuado' => (bool) $this->inadecuado,
        ]);
    }
}
