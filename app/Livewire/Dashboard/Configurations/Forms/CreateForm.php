<?php

namespace App\Livewire\Dashboard\Configurations\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\Configuration;

class CreateForm extends Form
{
    #[Rule('required|unique:configuration,param')]
    public $param = '';

    #[Rule('required')]
    public $value = '';

    public function save()
    {
        $this->validate();

        $configuration = Configuration::create($this->except([]));

        $this->reset();

        return $configuration;
    }

}
