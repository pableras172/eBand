<?php

namespace App\Livewire\Dashboard\Paymentresumes\Forms;

use Livewire\Form;
use App\Models\Payment;
use Livewire\Attributes\Rule;

class CreateDetailForm extends Form
{
    public $paymetresume_id = null;

    #[Rule('required|date')]
    public $fechaPago = '';

    #[Rule('required|string')]
    public $descripcion = '';

    #[Rule('required|date')]
    public $fechaInicio = '';

    #[Rule('required|date')]
    public $fechaFin = '';

    public function save()
    {
        $this->validate();

        $payment = Payment::create($this->except([]));

        $this->reset();

        return $payment;
    }
}
