<?php

namespace App\Livewire\Payment;

use App\Models\User;
use Livewire\Component;
use App\Models\Payment;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Payments\Forms\UpdateForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentDetail;

class PaymentEdit extends Component
{
    public ?Payment $payment = null;

    public UpdateForm $form;
    public Collection $users;
    public $userId; 

    public $confirmingDeletion = false;
    public $deletingPayment;


    public function mount(Payment $payment)
    {
        $this->payment = $payment->load('user');
        //$this->authorize('view-any', Payment::class,Auth::user(), $payment->user());
        $this->authorize('viewAny', [Payment::class, $payment->user]);

        $this->userId = $payment->users_id;        
        
        $this->form->setPayment($payment);
        $this->users = User::pluck('name', 'id');
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingPayment = $id;
        $this->confirmingDeletion = true;
    }

    public function delete(Payment $payment)
    {
        $payment->delete();
        $this->confirmingDeletion = false;  
        return redirect()->route('payments.index');      
    }

    public function save()
    {
        $this->authorize('update', $this->payment);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.payments.edit', ['pendiente'=>$this->payment->confirmadausuaroi]);
    }

    public function print()
    {
        $this->authorize('view', $this->payment);

        try {
            // Verificar que el usuario del pago tenga email
            if (!$this->payment->user || !$this->payment->user->email) {
                $this->dispatch('email-error');
                return;
            }

            // Recargar el payment con la relación user para asegurarnos
            $payment = Payment::with('user')->find($this->payment->id);

            // Enviar email al usuario del pago
            Mail::to($payment->user->email)->send(new PaymentDetail($payment));

            // Si el usuario logueado es diferente, enviar copia
            $currentUser = Auth::user();
            if ($currentUser->id !== $payment->user->id && $currentUser->email) {
                Mail::to($currentUser->email)->send(new PaymentDetail($payment));
            }

            $this->dispatch('email-sent');
        } catch (\Exception $e) {
            \Log::error('Error sending payment email: ' . $e->getMessage());
            $this->dispatch('email-error');
        }
    }

    public function confirm()
    {
        $this->authorize('update', $this->payment);
        $this->payment->confirmadausuaroi=1;
        $this->payment->save();

        $this->dispatch('confirmed');
    }

    public function noConfirmar()
    {
        $this->authorize('update', $this->payment);
        if($this->form->observaciones==''){
            $this->dispatch('errorobservaciones');
        }else{
            $this->payment->observaciones=$this->form->observaciones;
            $this->payment->confirmadausuaroi=0;
            $this->payment->save();
            $this->dispatch('notconfirmed');
        }
    }
}
