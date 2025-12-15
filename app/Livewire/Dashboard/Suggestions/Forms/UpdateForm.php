<?php

namespace App\Livewire\Dashboard\Suggestions\Forms;

use Livewire\Form;
use App\Models\Suggestion;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?Suggestion $suggestion;

    public $fechacreacion = '';

    public $titulo = '';

    public $texto = '';

    public $observaciones = '';

    public $users_id = '';

    public $anonimo = false;

    public function rules(): array
    {
        return [
            'fechacreacion' => ['required', 'date'],
            'titulo' => ['required', 'string'],
            'texto' => ['required', 'string'],
            'observaciones' => ['nullable', 'string'],
            'users_id' => ['nullable'],
        ];
    }

    public function setSuggestion(Suggestion $suggestion)
    {
        $this->suggestion = $suggestion;

        $this->fechacreacion = $suggestion->fechacreacion;
        $this->titulo = $suggestion->titulo;
        $this->texto = $suggestion->texto;
        $this->observaciones = $suggestion->observaciones;
        $this->users_id = $suggestion->users_id;
        $this->anonimo = $suggestion->anonimo;
    }

    public function save()
    {
        $this->validate();

        $this->suggestion->update($this->except(['suggestion']));
    }
}
