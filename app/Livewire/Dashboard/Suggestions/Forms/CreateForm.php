<?php

namespace App\Livewire\Dashboard\Suggestions\Forms;

use Livewire\Form;
use App\Models\Suggestion;
use Livewire\Attributes\Rule;

class CreateForm extends Form
{
    #[Rule('required|date')]
    public $fechacreacion = '';

    #[Rule('required|string')]
    public $titulo = '';

    #[Rule('required|string')]
    public $texto = '';

    #[Rule('nullable|string')]
    public $observaciones = '';

    #[Rule('nullable')]
    public $users_id = '';

    #[Rule('boolean')]
    public $anonimo=false;

    public function save()
    {
        $this->validate();

            
        $suggestion = Suggestion::create($this->except([]));

        $this->reset();

        return $suggestion;
    }
}
