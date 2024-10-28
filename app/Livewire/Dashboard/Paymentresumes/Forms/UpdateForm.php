<?php

namespace App\Livewire\Dashboard\Paymentresumes\Forms;

use Livewire\Form;
use App\Models\Paymentresume;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UpdateForm extends Form
{
    public ?Paymentresume $paymentresume;

    public $descripcion = '';

    public $user_id = '';

    public $created_at = '';

    public $document = '';

    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string'],
            'user_id' => ['required'],
            'created_at' => ['nullable', 'date'],
            'document' => ['nullable', 'url'],
        ];
    }

    public function setPaymetresume(Paymentresume $paymentresume)
    {
        $this->paymentresume = $paymentresume;

        $this->descripcion = $paymentresume->descripcion;
        $this->user_id = $paymentresume->user_id;
        $this->created_at = Carbon::parse($paymentresume->created_at)->format('Y-m-d H:i');
        $this->document = $paymentresume->document;
    }

    public function save()
    {
        $this->validate();

        $this->paymentresume->update($this->except(['paymentresume', 'user_id']));
    }
}
