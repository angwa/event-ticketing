<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdaterequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date_format:"d.m.Y"', 'max:55'],
            'price' => ['nullable', 'integer'],
            'type' => ['required', 'string', 'max:255', 'in:paid,free'],
            'status' => ['nullable', 'string','in:active,inactive', 'max:255'],
            'slots' => ['nullable', 'integer', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
