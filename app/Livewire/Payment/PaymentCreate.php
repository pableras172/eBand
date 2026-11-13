<?php

namespace App\Livewire\Payment;

use App\Models\Actuacion;
use App\Models\ListasUser;
use App\Models\Payment;
use App\Models\Paymentresume;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaymentCreate extends Component
{
    use WithFileUploads;

    public Collection $users;

    public array $form = [
        'users_id' => '',
        'fechaPago' => '',
        'descripcion' => '',
        'fechaInicio' => '',
        'fechaFin' => '',
    ];

    public $actuaciones;

    public function mount()
    {
        if (! Auth::user()->hasRole('Admin')) {
            abort(403, __('Sorry! You are not authorized to perform this action.'));
        }

        $this->users = User::where('activo', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $this->form['fechaPago'] = Carbon::now()->format('Y-m-d');
        $this->form['users_id'] = '0'; // Por defecto todos los usuarios
    }

    public function consultarActuaciones()
    {
        if ($this->form['users_id'] == -1 || $this->form['users_id'] === '') {
            $this->actuaciones = collect();

            return;
        }

        if (! empty($this->form['fechaInicio']) && ! empty($this->form['fechaFin'])) {
            if ($this->form['users_id'] == '0') { // Todos los usuarios
                $this->actuaciones = Actuacion::with(['tipoactuacion', 'contrato'])
                    ->whereBetween('fechaActuacion', [$this->form['fechaInicio'], $this->form['fechaFin']])
                    ->where('actuacions.noaplicapago', 0)
                    ->orderBy('fechaActuacion', 'asc')
                    ->get();
            } else { // Actuaciones del usuario seleccionado
                $this->actuaciones = Actuacion::with(['tipoactuacion', 'contrato'])
                    ->join('listas', 'actuacions.id', '=', 'listas.actuacions_id')
                    ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
                    ->where('listas_user.user_id', $this->form['users_id'])
                    ->where('listas_user.disponible', 1)
                    ->where('actuacions.noaplicapago', 0)
                    ->whereBetween('actuacions.fechaActuacion', [$this->form['fechaInicio'], $this->form['fechaFin']])
                    ->orderBy('actuacions.fechaActuacion', 'asc')
                    ->select('actuacions.*')
                    ->get();
            }
        }
    }

    public function updatedFormUsersId(): void
    {
        $this->consultarActuaciones();
    }

    public function updatedFormFechaInicio(): void
    {
        $this->consultarActuaciones();
    }

    public function updatedFormFechaFin(): void
    {
        $this->consultarActuaciones();
    }

    public function save()
    {
        $this->validate([
            'form.users_id' => 'required|not_in:-1',
            'form.fechaPago' => 'required|date',
            'form.descripcion' => 'required|string|max:255',
            'form.fechaInicio' => 'required|date',
            'form.fechaFin' => 'required|date|after_or_equal:form.fechaInicio',
        ], [
            'form.users_id.not_in' => __('Has de seleccionar un músic o triar tots els músics.'),
            'form.fechaFin.after_or_equal' => __('La data final ha de ser igual o posterior a la data d\'inici.'),
        ]);

        try {
            DB::transaction(function () {

                $paymentresume = new Paymentresume;
                $paymentresume->descripcion = $this->form['descripcion'];
                $paymentresume->user_id = Auth::user()->id;
                $paymentresume->save();

                $usersQuery = $this->form['users_id'] == 0
                    ? User::where('activo', 1)->orderBy('name', 'asc')->get()
                    : User::where('id', $this->form['users_id'])->orderBy('name', 'asc')->get();

                foreach ($usersQuery as $user) {
                    Log::info('Processing user: ', ['id' => $user->id, 'name' => $user->name]);
                    $paymentData = $this->form;
                    $paymentData['users_id'] = $user->id;
                    $paymentData['descripcion'] = $paymentData['descripcion'].'-'.$user->name;

                    $actuaciones = Actuacion::join('listas', 'actuacions.id', '=', 'listas.actuacions_id')
                        ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
                        ->where('listas_user.user_id', $user->id)
                        ->where('listas_user.pagada', 0)
                        ->where('listas_user.disponible', 1)
                        ->where('actuacions.noaplicapago', 0)
                        ->whereBetween('actuacions.fechaActuacion', [$this->form['fechaInicio'], $this->form['fechaFin']])
                        ->select('actuacions.*', 'listas.id as listas_id')
                        ->get();

                    if ($actuaciones->isNotEmpty()) {
                        $payment = Payment::create($paymentData);

                        $totalPagoFinal = 0;

                        foreach ($actuaciones as $actuacion) {
                            Log::info('Processing actuacion: ', ['id' => $actuacion->id, 'descripcion' => $actuacion->descripcion]);

                            $listaUser = ListasUser::where('listas_id', $actuacion->listas_id)
                                ->where('user_id', $user->id)
                                ->first();

                            if ($listaUser) {
                                $listaUser->payment_id = $payment->id;

                                $porcentaje = 1;
                                if ($actuacion->aplicaporcentaje) {
                                    $porcentaje = ! empty($actuacion->porcentajepersonal) && $actuacion->porcentajepersonal > 0
                                        ? $actuacion->porcentajepersonal / 100
                                        : ($user->porcentaje > 0 ? $user->porcentaje / 100 : 0);
                                }

                                $totalActuacion = $actuacion->preciomusico * $porcentaje;
                                $totalCoche = $actuacion->preciocoche * $listaUser->coche;
                                $totalFurgo = $actuacion->preciofurgona * $listaUser->furgona;
                                $totalActo = $totalActuacion + $totalCoche + $totalFurgo;

                                $listaUser->totalActuacion = $totalActuacion;
                                $listaUser->totalActo = $totalActo;
                                $listaUser->totalCoche = $totalCoche;
                                $listaUser->totalFurgo = $totalFurgo;
                                $listaUser->cuentas = 1;
                                // Guardar los cambios en la base de datos
                                $listaUser->save();

                                $totalPagoFinal += $totalActo;
                            }
                        }
                        $payment->paymentresume_id = $paymentresume->id;
                        $payment->totalPago = $totalPagoFinal;
                        $payment->save();
                    }
                }
            });

            Log::info('Payment created successfully.');
            session()->flash('flash.banner', __('Liquidació generada correctament.'));
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('payments.index');
        } catch (\Exception $e) {
            Log::error('Error creating payment: ', ['error' => $e->getMessage()]);
            session()->flash('flash.banner', __('Error generant la liquidació: ').$e->getMessage());
            session()->flash('flash.bannerStyle', 'danger');

            return redirect()->route('payments.index');
        }
    }

    public function render()
    {
        return view('livewire.payments.create', []);
    }
}
