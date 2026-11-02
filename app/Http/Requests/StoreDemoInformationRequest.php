<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemoInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && (bool) $this->session()->get('demo_mode');
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'nombre_apellidos' => ['required', 'string', 'max:255'],
            'email_contacto' => ['required', 'email', 'max:255'],
            'telefono_contacto' => ['required', 'string', 'max:30'],
            'nombre_banda' => ['nullable', 'string', 'max:255'],
            'numero_musicos' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'notas' => ['required', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre_apellidos.required' => 'Indica tu nombre y apellidos.',
            'email_contacto.required' => 'Indica un email de contacto.',
            'email_contacto.email' => 'El email de contacto no es valido.',
            'telefono_contacto.required' => 'Indica un telefono de contacto.',
            'numero_musicos.integer' => 'El numero de musicos debe ser un numero entero.',
            'numero_musicos.min' => 'El numero de musicos debe ser al menos 1.',
            'notas.required' => 'Escribe algunas notas para que podamos ayudarte mejor.',
        ];
    }
}
