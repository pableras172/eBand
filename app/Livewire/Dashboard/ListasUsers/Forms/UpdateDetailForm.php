<?php

namespace App\Livewire\Dashboard\ListasUsers\Forms;

use App\Models\ListasUser;
use Livewire\Form;

class UpdateDetailForm extends Form
{
    public ?ListasUser $listasUser;

    public $coche = '';

    public $furgona = '';

    public $pagada = '';

    public $cuentas = '';

    public $disponible = '';

    public function rules(): array
    {
        return [
            'coche' => ['nullable', 'boolean'],
            'furgona' => ['nullable', 'boolean'],
            'pagada' => ['nullable', 'boolean'],
            'cuentas' => ['nullable', 'boolean'],
            'disponible' => ['nullable', 'boolean'],
        ];
    }

    public function setListasUser(ListasUser $listasUser)
    {
        $this->listasUser = $listasUser;

        $this->coche = (bool) $listasUser->coche;
        $this->furgona = (bool) $listasUser->furgona;
        $this->pagada = (bool) $listasUser->pagada;
        $this->cuentas = (bool) $listasUser->cuentas;
        $this->disponible = (bool) $listasUser->disponible;
    }

    public function save()
    {
        $this->validate();

        $this->listasUser->update($this->except(['listasUser']));
    }
}
