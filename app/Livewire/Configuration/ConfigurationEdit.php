<?php

namespace App\Livewire\Configuration;

use Livewire\Component;
use App\Models\Configuration;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Configurations\Forms\UpdateForm;

class ConfigurationEdit extends Component
{
    public ?Configuration $configuration = null;

    public UpdateForm $form;

    public function mount(Configuration $configuration)
    {
        $this->authorize('view-any', Configuration::class);

        $this->configuration = $configuration;

        $this->form->setConfiguration($configuration);
    }

    public function save()
    {
        $this->authorize('update', $this->configuration);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.configurations.edit', []);
    }
}
