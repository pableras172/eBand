<?php

namespace App\Livewire;

use App\Models\Actuacion;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PreviewListas extends Component
{
    public $displayingPreviewListas = false;

    public $id;

    public $floatButon = false;

    public $showingModal = false;

    public $listeners = [
        'hideMe' => 'hideModal',
    ];

    public $detallesLista = [
        'actuacion' => [],
        'usuarios' => [],
        'lista' => [],
        'totalFilas' => [],
        'cochesCount' => [],
        'antelacion' => [],
    ];

    public function mount($id)
    {
        $this->id = $id;
    }

    public function showModal()
    {
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    /*public function render()
    {
        return view('livewire.preview-listas');
    }*/

    public function render()
    {
        $actuacionId = $this->id;

        // Obtener la actuación y la lista relacionada
        $actuacion = Actuacion::findOrFail($actuacionId);
        $lista = $actuacion->lista;

        if (
            $lista && $lista->users && $lista->users->contains(Auth::user()->id)
            && ! $lista->users()->where('users.id', (Auth::user()->id))->first()->pivot->disponible
        ) {
            $usuarioDisponible = false;
        }

        // Obtener todos los usuarios
        $usuarios = User::with('instrument')
            ->where('activo', 1)
            ->whereNotNull('instrument_id')
            ->whereDoesntHave('hijos') // no es padre
            ->get();

        // Marcar los usuarios seleccionados y con coche
        foreach ($usuarios as $usuario) {
            $usuario->seleccionado = false; // Por defecto, no seleccionado
            $usuario->coche = false; // Por defecto, no marcado
            $usuario->furgona = false; // Por defecto, no marcado
            $usuario->disponible = true;
            // Verificar si el usuario está en la lista
            if ($lista && $lista->users && $lista->users->contains($usuario->id)) {
                $userPivot = $lista->users()->where('users.id', $usuario->id)->first()?->pivot;
                if (! $userPivot || ! $userPivot->disponible) {
                    $usuario->disponible = false;

                    continue;
                }
                $usuario->seleccionado = true;
                // Verificar si el usuario tiene marcado el campo coche en la lista
                if ($userPivot->coche) {
                    $usuario->coche = true;
                }
                if ($userPivot->furgona) {
                    $usuario->furgona = true;
                }
            }
        }

        $totalFilas = $lista ? ListasUser::where('listas_id', $lista->id)->where('disponible', '<>', 0)->count() : 0;
        $cochesCount = $lista ? ListasUser::where('listas_id', $lista->id)->where(function ($q) {
            $q->where('coche', 1)->orWhere('furgona', 1);
        })->count() : 0;

        // Verificar si la lista está mostrándose y si hay usuarios disponibles
        return view('livewire.preview-listas', compact('actuacion', 'usuarios', 'lista', 'totalFilas', 'cochesCount'));
    }

    public function getUsuariosDisponibles($listaId)
    {
        return ListasUser::where('listas_id', $listaId)
            ->where('disponible', 1)
            ->with(['user' => function ($query) {
                $query->with('instrument');
            }])
            ->get();
    }
}
