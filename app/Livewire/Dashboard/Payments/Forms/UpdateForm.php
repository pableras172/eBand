<?php

namespace App\Livewire\Dashboard\Payments\Forms;

use Livewire\Form;
use App\Models\Payment;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UpdateForm extends Form
{
    public ?Payment $payment;

    public $fechaPago = '';

    public $descripcion = '';

    public $users_id = '';
    public $fechaInicio = '';
    public $fechaFin = '';
    public $totalPago = '';
    public $porcentaje = '';
    public $observaciones='';

    public $userId;

    public function rules(): array
    {
        return [
            'fechaPago' => ['required', 'date'],
            'descripcion' => ['required', 'string', 'min:10'],
            'users_id' => ['required'],
        ];
    }

    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;
    
        // Asigna la fecha de pago
        $this->fechaPago = Carbon::parse($payment->fechaPago)->format('Y-m-d');
    
        // Asigna la fecha de inicio si está presente
        if ($payment->fechaInicio) {
            $this->fechaInicio = Carbon::parse($payment->fechaInicio)->format('Y-m-d');
        }
    
        // Asigna la fecha de fin si está presente
        if ($payment->fechaFin) {
            $this->fechaFin = Carbon::parse($payment->fechaFin)->format('Y-m-d');
        }
    
        // Asigna otros campos
        $this->descripcion = $payment->descripcion;
        $this->users_id = $payment->users_id;
        $this->userId = $payment->users_id;
        $this->totalPago = $payment->totalPago;
        $this->porcentaje = $payment->user->porcentaje;
        $this->observaciones = $payment->observaciones;
        
    }
    
    public function save()
    {
        $this->validate();

        $this->payment->update($this->except(['payment', 'users_id']));
    }
}
