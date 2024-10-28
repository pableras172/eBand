<?php

namespace App\Livewire\Dashboard\Payments\Forms;

use Livewire\Form;
use App\Models\Payment;
use Livewire\Attributes\Rule;

class CreateForm extends Form
{
    #[Validate('required|date')]
    public $fechaPago = '';

    #[Validate('required|string|min:10')]
    public $descripcion = '';

    #[Validate('required')]
    public $users_id = '';

    #[Validate('required|date|before:fechaFin')]
    public $fechaInicio = '';

    #[Validate('required|date|after:fechaInicio')]
    public $fechaFin = '';

    public function save()
    {
        $this->validate();

        $payment = Payment::create($this->except([]));

        $this->reset();

        return $payment;
    }

}
