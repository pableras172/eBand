<?php

namespace App\Livewire\Payment;

use App\Livewire\Dashboard\Payments\Forms\UpdateForm;
use App\Mail\PaymentDetail;
use App\Models\ListasUser;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class PaymentEdit extends Component
{
    public ?Payment $payment = null;

    public UpdateForm $form;

    public Collection $users;

    public $userId;

    public $confirmingDeletion = false;

    public $deletingPayment;

    // Modal y edición rápida del porcentaje del músico
    public bool $showingUserPorcentajeModal = false;

    public float|string $userPorcentaje = '';

    #[On('refresh-payment')]
    public function onPaymentUpdated(): void
    {
        $this->payment?->refresh();
        if ($this->payment) {
            $this->form->totalPago = (string) $this->payment->totalPago;
        }
    }

    public function mount(Payment $payment)
    {
        $this->payment = $payment->load('user');
        // $this->authorize('view-any', Payment::class,Auth::user(), $payment->user());
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
        return view('livewire.payments.edit', ['pendiente' => $this->payment->confirmadausuaroi]);
    }

    public function print()
    {
        $this->authorize('view', $this->payment);

        try {
            // Verificar que el usuario del pago tenga email
            if (! $this->payment->user || ! $this->payment->user->email) {
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
            \Log::error('Error sending payment email: '.$e->getMessage());
            $this->dispatch('email-error');
        }
    }

    public function confirm()
    {
        $this->authorize('update', $this->payment);
        $this->payment->confirmadausuaroi = 1;
        $this->payment->save();

        $this->dispatch('confirmed');
    }

    public function resolverIncidencia(): void
    {
        $this->authorize('update', $this->payment);

        $total = ListasUser::where('payment_id', $this->payment->id)->sum('totalActo');
        $this->payment->totalPago = (float) $total;
        $this->payment->confirmadausuaroi = true;

        if ($this->payment->observaciones && ! str_contains($this->payment->observaciones, '[Incidència resolta]')) {
            $this->payment->observaciones .= "\n✓ [Incidència resolta per administració]";
        }

        $this->payment->save();
        $this->form->totalPago = (string) $this->payment->totalPago;
        $this->form->observaciones = $this->payment->observaciones;

        $this->dispatch('incidencia-resuelta');
    }

    public function openUserPorcentajeModal(): void
    {
        $this->authorize('update', $this->payment);

        $this->userPorcentaje = (float) ($this->payment->user->porcentaje ?: 100);
        $this->showingUserPorcentajeModal = true;
    }

    public function closeUserPorcentajeModal(): void
    {
        $this->showingUserPorcentajeModal = false;
    }

    public function saveUserPorcentaje(): void
    {
        $this->authorize('update', $this->payment);

        $this->validate([
            'userPorcentaje' => 'required|numeric|min:0|max:100',
        ]);

        $user = $this->payment->user;
        $user->porcentaje = (float) $this->userPorcentaje;
        $user->save();

        // Recalcular actuaciones vinculadas a este pago
        $listasUsers = ListasUser::where('payment_id', $this->payment->id)->with('listas.actuacion')->get();
        foreach ($listasUsers as $lu) {
            $actuacion = $lu->listas?->actuacion;
            if ($actuacion && $actuacion->aplicaporcentaje && empty($actuacion->porcentajepersonal)) {
                $totalActuacion = (float) $actuacion->preciomusico * ($user->porcentaje / 100);
                $totalActo = $totalActuacion + (float) $lu->totalCoche + (float) $lu->totalFurgo;
                $lu->totalActuacion = $totalActuacion;
                $lu->totalActo = $totalActo;
                $lu->save();
            }
        }

        // Recalcular el total del pago
        $total = ListasUser::where('payment_id', $this->payment->id)->sum('totalActo');
        $this->payment->totalPago = (float) $total;
        $this->payment->save();

        $this->form->totalPago = (string) $this->payment->totalPago;
        $this->form->porcentaje = (string) $user->porcentaje;

        $this->closeUserPorcentajeModal();
        $this->dispatch('user-porcentaje-updated');
    }

    public function noConfirmar()
    {
        $this->authorize('update', $this->payment);
        if ($this->form->observaciones == '') {
            $this->dispatch('errorobservaciones');
        } else {
            $this->payment->observaciones = $this->form->observaciones;
            $this->payment->confirmadausuaroi = 0;
            $this->payment->save();
            $this->dispatch('notconfirmed');
        }
    }
}
