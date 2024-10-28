<?php

namespace App\Livewire\Dashboard\ListasUsers\Forms;

use Livewire\Form;
use App\Models\ListasUser;
use Livewire\Attributes\Rule;

class CreateDetailForm extends Form
{
    public $payment_id = null;

    #[Rule('required|boolean')]
    public $coche = '';

    #[Rule('required|boolean')]
    public $pagada = '';

    #[Rule('required|boolean')]
    public $cuentas = '';

    #[Rule('required|boolean')]
    public $disponible = '';

    public function save()
    {
        $this->validate();

        $listasUser = ListasUser::create($this->except([]));

        $this->reset();

        return $listasUser;
    }
}
