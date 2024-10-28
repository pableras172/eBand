<?php

namespace App\Livewire\Configuration;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Configurations\Forms\CreateForm;

class ConfigurationCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
    }

    public function save()
    {
        $this->authorize('create', Configuration::class);

        $this->validate();

        $configuration = $this->form->save();

        return redirect()->route('configurations.edit', $configuration);
    }

    public function render()
    {
        return view('livewire.configurations.create', []);
    }
}
