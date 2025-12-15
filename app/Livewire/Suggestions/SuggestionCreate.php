<?php

namespace App\Livewire\Suggestions;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Suggestions\Forms\CreateForm;
use \App\Models\Suggestion;

class SuggestionCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
        $this->form->fechacreacion = now()->format('Y-m-d H:i');
        $this->form->users_id = auth()->id();
    }

    public function save()
    {
        $this->authorize('create', Suggestion::class);

        $this->validate();

        $suggestion = $this->form->save();

        return redirect()->route('suggestions.index', $suggestion);
    }

    public function render()
    {        
        return view('livewire.suggestions.create');
    }
}
