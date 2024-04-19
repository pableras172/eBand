<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'          => ['required', 'string'],
            'instrument_id' => ['required', 'exists:instruments,id'],
            'email'         => ['required', 'email', 'unique:users'],
            'password'      => ['required', 'string', 'min:8'],
            'telefono'      => ['required', 'string'],
            'uuid'      => ['string'],
            'porcentaje'    => ['required', 'numeric'],
            'fechaAlta'     => ['required', 'date'],
            'roles.*'       => ['integer'],
            'roles'         => ['required', 'array'],
        ];
    }

    public function authorize()
    {
        return Gate::allows('user_access');
    }
}