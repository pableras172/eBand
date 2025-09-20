<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'    => ['string', 'required'],
            'email'   => ['required', 'unique:users,email,' . request()->route('user')->id],
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
}
