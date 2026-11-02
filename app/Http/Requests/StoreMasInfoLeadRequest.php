<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasInfoLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'interes' => ['required', 'in:busco_banda,soy_banda'],
            'nombre_apellidos' => ['required', 'string', 'max:255'],
            'entidad' => ['nullable', 'string', 'max:255', 'required_if:interes,busco_banda'],
            'municipio' => ['nullable', 'string', 'max:255', 'required_if:interes,busco_banda'],
            'telefono_contacto' => ['required', 'string', 'max:30'],
            'email_contacto' => ['required', 'email', 'max:255'],
            'mensaje' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'interes.required' => 'Selecciona una opcion para continuar.',
            'interes.in' => 'La opcion seleccionada no es valida.',
            'nombre_apellidos.required' => 'Indica tu nombre y apellidos.',
            'entidad.required_if' => 'Indica la comparsa o asociacion.',
            'municipio.required_if' => 'Indica el municipio.',
            'telefono_contacto.required' => 'Indica un telefono de contacto.',
            'email_contacto.required' => 'Indica un correo de contacto.',
            'email_contacto.email' => 'El correo de contacto no es valido.',
        ];
    }
}
