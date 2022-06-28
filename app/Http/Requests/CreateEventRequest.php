<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date_format:"d.m.Y"', 'max:55'],
            'price' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255', 'in:paid,free'],
            'status' => ['nullable', 'string','in:active,inactive', 'max:255'],
            'slots' => ['nullable', 'integer', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
