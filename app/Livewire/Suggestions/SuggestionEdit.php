<?php

namespace App\Livewire\Suggestions;

use Livewire\Component;
use App\Models\Suggestion;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Suggestions\Forms\UpdateForm;

class SuggestionEdit extends Component
{
    public ?Suggestion $suggestion = null;

    public UpdateForm $form;

    public function mount(Suggestion $suggestion)
    {
        $this->authorize('view-any', Suggestion::class);

        $this->suggestion = $suggestion;

        $this->form->setSuggestion($suggestion);
    }

    public function save()
    {
        $this->authorize('update', $this->suggestion);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.suggestions.edit', []);
    }
}
