<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConcertProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'event_time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'participants' => ['nullable', 'string', 'max:2500'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean', 'prohibited_unless:is_published,1'],
            'image' => ['nullable', 'image', 'max:4096'],
            'logo_1' => ['nullable', 'image', 'max:2048'],
            'logo_2' => ['nullable', 'image', 'max:2048'],
            'logo_3' => ['nullable', 'image', 'max:2048'],
            'repertoire' => ['required', 'array', 'min:1'],
            'repertoire.*.title' => ['required', 'string', 'max:255'],
            'repertoire.*.author' => ['nullable', 'string', 'max:255'],
            'repertoire.*.details' => ['nullable', 'string', 'max:2000'],
            'repertoire.*.url' => ['nullable', 'url', 'max:2048'],
            'repertoire.*.sort_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'repertoire.required' => __('Debes añadir al menos una obra al repertorio.'),
            'repertoire.min' => __('Debes añadir al menos una obra al repertorio.'),
            'repertoire.*.title.required' => __('Cada obra del repertorio debe tener título.'),
            'is_featured.prohibited_unless' => __('Solo puedes destacar un programa publicado.'),
        ];
    }
}
