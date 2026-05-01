<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBandSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'nif_cif' => ['nullable', 'string', 'max:30'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'iduserpresidente' => ['nullable', 'exists:users,id'],
            'urlinstagram' => ['nullable', 'url', 'max:255'],
            'urlfacebook' => ['nullable', 'url', 'max:255'],
            'urltiktok' => ['nullable', 'url', 'max:255'],
        ];
    }
}
