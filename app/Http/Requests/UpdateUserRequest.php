<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'    => [
                'string',
                'required',
            ],
            'email'   => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'roles.*' => [
                'integer',
            ],
            'roles'   => [
                'required',
                'array',
            ],
            'instrument_id'=> ['exists:instruments,id'],
            'telefono'     => ['required', 'string'],
            'porcentaje'   => ['required', 'numeric'],
            'fechaAlta'    => ['required', 'date'],
        ];
    }

    public function authorize()
    {
        return Gate::allows('user_access');
    }
}