<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;


class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'      => ['required', 'string'],
            'email'     => ['required', 'email', 'unique:users'],
            'password'  => ['required', 'string', 'min:8'],
            'telefono'  => ['required', 'string'],
            'uuid'      => ['string'],
            'fechaAlta' => ['required', 'date'],
            'roles.*'   => ['integer'],
            'roles'     => ['required', 'array'],

            // estas se ajustan dinámicamente
            'instrument_id' => ['nullable', 'exists:instruments,id'],
            'porcentaje'    => ['nullable', 'numeric'],
        ];
    }


public function withValidator($validator)
{
    Log::debug('Valor de es_padre en la petición:', ['es_padre' => $this->es_padre]);

    $validator->sometimes(['instrument_id', 'porcentaje'], 'required', function ($input) {
        return !$input->es_padre;
    });
}




    public function authorize()
    {
        return Gate::allows('user_access');
    }
}
