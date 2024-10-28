<?php

namespace App\Livewire\Dashboard\Paymentresumes\Forms;

use Livewire\Form;
use App\Models\Paymentresume;
use Livewire\Attributes\Rule;

class CreateForm extends Form
{
    #[Rule('required|string')]
    public $descripcion = '';

    #[Rule('required')]
    public $user_id = '';

    #[Rule('nullable|date')]
    public $created_at = '';

    #[Rule('nullable|url')]
    public $document = '';

    public function save()
    {
        $this->validate();

        $paymentresume = Paymentresume::create($this->except([]));

        $this->reset();

        return $paymentresume;
    }
}
