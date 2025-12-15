<?php

namespace App\Livewire\Dashboard\Suggestions\Forms;

use Livewire\Form;
use App\Models\Suggestion;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UpdateForm extends Form
{
    public ?Suggestion $suggestion;

    public $fechacreacion = '';

    public $titulo = '';

    public $texto = '';

    public $observaciones = '';

    public $users_id = '';

    public $anonimo = false;

    public function rules(): array
    {
        return [
            'fechacreacion' => ['required', 'date'],
            'titulo' => ['required', 'string'],
            'texto' => ['required', 'string'],
            'observaciones' => ['nullable', 'string'],
            'users_id' => ['nullable'],
            'anonimo' => ['boolean'],
        ];
    }

    public function setSuggestion(Suggestion $suggestion)
    {
        $this->suggestion = $suggestion;

        $this->fechacreacion = $suggestion->fechacreacion;
        $this->titulo = $suggestion->titulo;
        $this->texto = $suggestion->texto;
        $this->observaciones = $suggestion->observaciones;
        $this->users_id = $suggestion->users_id;
        $this->anonimo = (bool) $suggestion->anonimo;
    }

    public function save()
    {
        try {
            $this->validate();

            $this->suggestion->update($this->except(['suggestion']));
        } catch (\Throwable $e) {
            Log::error('Error al guardar sugerencia', [
                'suggestion_id' => $this->suggestion->id ?? null,
                'data' => $this->except(['suggestion']),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // re-lanzar para que Livewire muestre errores de validación/servidor
        }
    }
}
