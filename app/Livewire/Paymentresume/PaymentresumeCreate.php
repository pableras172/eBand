<?php

namespace App\Livewire\Paymentresume;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Paymetresumes\Forms\CreateForm;

class PaymentresumeCreate extends Component
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
        $this->authorize('create', Paymentresume::class);

        $this->validate();

        $paymentresume = $this->form->save();

        return redirect()->route('.paymetresumes.edit', $paymentresume);
    }

    public function render()
    {
        return view('livewire.payments.paymetresumes.create', []);
    }
}
