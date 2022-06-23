<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'status' => 'required',
            'lesson_id' => 'required',
            'user_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'El estado es requerido.',
            'lesson_id.required' => 'La clase es requerida.',
            'user_id.required' => 'El usuario es requerido.'
        ];
    }
}
