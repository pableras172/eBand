<?php

namespace App\Livewire\Paymentresume;

use App\Models\User;
use Livewire\Component;
use App\Models\Paymentresume;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Paymentresumes\Forms\UpdateForm;

class PaymentresumeEdit extends Component
{
    public ?Paymentresume $paymetresume = null;

    public UpdateForm $form;
    public Collection $users;

    public function mount(Paymentresume $paymetresume)
    {
        //$this->authorize('view-any', Paymentresume::class);

        $this->paymetresume = $paymetresume;

        $this->form->setPaymetresume($paymetresume);
        $this->users = User::pluck('name', 'id');
    }

    public function save()
    {
        $this->authorize('update', $this->paymentresume);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.payments.paymentresumes.edit', []);
    }

    public function print()
    {
        // Redireccionar a la ruta que genera el PDF
        return redirect()->route('pdf.paymentresume', ['paymentresume' => $this->paymetresume]);
    }
}
