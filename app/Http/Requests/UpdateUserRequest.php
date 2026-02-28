<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'    => ['string', 'required'],
            'email'   => ['required', 'unique:users,email,' . request()->route('user')->id],
            'password' => ['nullable', 'string', 'min:8'],
            'roles.*' => ['integer'],
            'roles'   => ['required', 'array'],
            'telefono'   => ['required', 'string'],
            'fechaAlta'  => ['required', 'date'],

            'instrument_id' => [
                'nullable',
                'exists:instruments,id',
                'required_unless:es_padre,1',
            ],
            'porcentaje' => [
                'nullable',
                'numeric',
                'required_unless:es_padre,1',
            ],
        ];
    }


    public function authorize()
    {
        return Gate::allows('user_access');
    }

    protected function prepareForValidation()
    {
        // Si el password está vacío, lo eliminamos para que no se actualice
        if (!$this->filled('password')) {
            $this->request->remove('password');
        } else {
            $this->merge([
                'password' => Hash::make($this->password),
            ]);
        }
    }
}
