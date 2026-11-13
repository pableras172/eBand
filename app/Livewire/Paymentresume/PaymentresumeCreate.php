<?php

namespace App\Livewire\Paymentresume;

use App\Livewire\Dashboard\Paymentresumes\Forms\CreateForm;
use App\Models\Paymentresume;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaymentresumeCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public Collection $users;

    public function mount()
    {
        $this->users = User::pluck('name', 'id');
        $this->form->user_id = Auth::id();
        $this->form->created_at = now()->format('Y-m-d H:i');
    }

    public function save()
    {
        $this->authorize('create', Paymentresume::class);

        $this->validate();

        $paymentresume = $this->form->save();

        return redirect()->route('paymentresumes.edit', $paymentresume);
    }

    public function render()
    {
        return view('livewire.payments.paymentresumes.create', []);
    }
}
