<?php

namespace App\Livewire\Dashboard\Configurations\Forms;

use Livewire\Form;
use App\Models\Configuration;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?Configuration $configuration;

    public $param = '';

    public $value = '';

    public function rules(): array
    {
        return [
            'param' => [
                'required',
                Rule::unique('configuration', 'param')->ignore(
                    $this->configuration
                ),
            ],
            'value' => ['required'],
        ];
    }

    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        $this->param = $configuration->param;
        $this->value = $configuration->value;
    }

    public function save()
    {
        $this->validate();

        $this->configuration->update($this->except(['configuration']));
    }
}
