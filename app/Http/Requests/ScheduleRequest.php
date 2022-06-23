<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'start_hour' => 'required',
            'end_hour' => 'required',
        ];
    }
    
    public function messages()
    {
        return [ 
            'start_hour.required' => 'El campo de "Hora inicial" es requerido.',
            'end_hour.required' => 'El campo de "Hora final" es requerido.',
        ];
    }
}
