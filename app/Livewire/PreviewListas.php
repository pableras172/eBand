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

    public $displayingPreviewListas= false;
    public $id;

    public $showingModal = false;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public $detallesLista = [
        'actuacion' => [],
        'usuarios'=>[],
        'lista'=>[],
        'totalFilas'=>[],
        'cochesCount'=>[],
        'antelacion'=>[],
    ];

    public function mount($id)
    {
        $this->id = $id;
    }

    public function showModal(){
        $this->showingModal = true;
    }

    public function hideModal(){
        $this->showingModal = false;
    }

    /*public function render()
    {
        return view('livewire.preview-listas');
    }*/

    public function render()
    {
        $actuacionId=$this->id;
        // Obtener la actuación y la lista relacionada
        $actuacion = Actuacion::findOrFail($actuacionId);
        $lista = $actuacion->lista;

        // Obtener todos los usuarios
        $usuarios = User::where('activo', 1)->get();

        // Marcar los usuarios seleccionados y con coche
        foreach ($usuarios as $usuario) {
            $usuario->seleccionado = false; // Por defecto, no seleccionado
            $usuario->coche = false; // Por defecto, no marcado
           
            // Verificar si el usuario está en la lista
            if ($lista->users->contains($usuario->id)) {       

                $usuario->seleccionado = true;
                // Verificar si el usuario tiene marcado el campo coche en la lista
                if ($lista->users()->where('id', $usuario->id)->first()->pivot->coche) {
                    $usuario->coche = true;
                }
                
            }
        }

        // Contar el número total de filas en ListasUser con el lista_id dado
        $totalFilas = ListasUser::where('listas_id', $lista->id)->where('disponible','<>','0')->count();

        // Contar el número de elementos con el campo "coche" igual a 1
        $cochesCount = ListasUser::where('listas_id', $lista->id)->where('coche', 1)->count();
        
        return view('livewire.preview-listas', compact('actuacion', 'usuarios','lista','totalFilas','cochesCount'));
    }
}
