<?php

namespace App\Livewire\Payment;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Payments\Forms\CreateForm;

class PaymentCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;
    public Collection $users;

    public function mount()
    {
        $this->users = User::pluck('name', 'id');
    }

    public function save()
    {
        $this->authorize('create', Payment::class);

        $this->validate();

        $payment = $this->form->save();

        return redirect()->route('payments.edit', $payment);
    }

    public function render()
    {
        return view('livewire.payments.create', []);
    }
}
