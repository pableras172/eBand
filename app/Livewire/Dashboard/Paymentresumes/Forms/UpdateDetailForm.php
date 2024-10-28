<?php

namespace App\Livewire\Dashboard\Paymentresumes\Forms;

use Livewire\Form;
use App\Models\Payment;
use Livewire\Attributes\Rule;

class UpdateDetailForm extends Form
{
    public ?Payment $payment;

    public $fechaPago = '';

    public $descripcion = '';

    public $fechaInicio = '';

    public $fechaFin = '';

    public function rules(): array
    {
        return [
            'fechaPago' => ['required', 'date'],
            'descripcion' => ['required', 'string'],
            'fechaInicio' => ['required', 'date'],
            'fechaFin' => ['required', 'date'],
        ];
    }

    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;

        $this->fechaPago = $payment->fechaPago;
        $this->descripcion = $payment->descripcion;
        $this->fechaInicio = $payment->fechaInicio;
        $this->fechaFin = $payment->fechaFin;
    }

    public function save()
    {
        $this->validate();

        $this->payment->update($this->except(['payment']));
    }
}
