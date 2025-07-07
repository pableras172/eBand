<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Listas;
use App\Models\User;
use App\Models\Actuacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ListasUser;
use DateTime;

class PreviewListas extends Component
{

    public $displayingPreviewListas = false;
    public $id;
    public $floatButon = false;

    public $showingModal = false;

    public $listeners = [
        'hideMe' => 'hideModal'
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
            && !$lista->users()->where('users.id', (Auth::user()->id))->first()->pivot->disponible
        ) {
            $usuarioDisponible = false;
        }

        // Obtener todos los usuarios
        $usuarios = User::where('activo', 1)
            ->whereDoesntHave('hijos') // no es padre
            ->get();


        // Marcar los usuarios seleccionados y con coche
        foreach ($usuarios as $usuario) {
            $usuario->seleccionado = false; // Por defecto, no seleccionado
            $usuario->coche = false; // Por defecto, no marcado
            $usuario->disponible = true;
            // Verificar si el usuario está en la lista
            if ($lista && $lista->users && $lista->users->contains($usuario->id)) {
                if (!$lista->users()->where('users.id', $usuario->id)->first()->pivot->disponible) {
                    $usuario->disponible = false;
                    continue;
                }
                $usuario->seleccionado = true;
                // Verificar si el usuario tiene marcado el campo coche en la lista
                if ($lista->users()->where('users.id', $usuario->id)->first()->pivot->coche) {
                    $usuario->coche = true;
                }
            }
        }

        // Verificar si la lista está mostrándose y si hay usuarios disponibles
        return view('livewire.preview-listas', compact('actuacion', 'usuarios', 'lista'));
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
