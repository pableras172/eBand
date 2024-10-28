<?php

namespace App\Livewire\Dashboard\ListasUsers\Forms;

use Livewire\Form;
use App\Models\ListasUser;
use Livewire\Attributes\Rule;

class UpdateDetailForm extends Form
{
    public ?ListasUser $listasUser;

    public $coche = '';

    public $pagada = '';

    public $cuentas = '';

    public $disponible = '';

    public function rules(): array
    {
        return [
            'coche' => ['required', 'boolean'],
            'pagada' => ['required', 'boolean'],
            'cuentas' => ['required', 'boolean'],
            'disponible' => ['required', 'boolean'],
        ];
    }

    public function setListasUser(ListasUser $listasUser)
    {
        $this->listasUser = $listasUser;

        $this->coche = $listasUser->coche;
        $this->pagada = $listasUser->pagada;
        $this->cuentas = $listasUser->cuentas;
        $this->disponible = $listasUser->disponible;
    }

    public function save()
    {
        $this->validate();

        $this->listasUser->update($this->except(['listasUser']));
    }
}
