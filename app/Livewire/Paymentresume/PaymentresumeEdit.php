<?php

namespace App\Livewire\Paymentresume;

use App\Models\User;
use Livewire\Component;
use App\Models\Paymentresume;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Paymentresumes\Forms\UpdateForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentresumeDetail;

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
        try {
            $currentUser = Auth::user();
            
            // Verificar que el usuario tenga email
            if (!$currentUser || !$currentUser->email) {
                $this->dispatch('email-error');
                return;
            }

            // Recargar el paymentresume con los pagos relacionados
            $paymentresume = Paymentresume::with('payments.user')->find($this->paymetresume->id);

            // Enviar email al usuario logueado
            Mail::to($currentUser->email)->send(new PaymentresumeDetail($paymentresume));

            $this->dispatch('email-sent');
        } catch (\Exception $e) {
            \Log::error('Error sending paymentresume email: ' . $e->getMessage());
            $this->dispatch('email-error');
        }
    }
}
