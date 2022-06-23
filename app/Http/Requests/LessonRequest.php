<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'coach' => 'required',
            'location' => 'required',
            'type' => 'required',
            'schedule_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'coach.required' => 'El campo de "Entrenado(a)" es requerido',
            'location.required' => 'El campo de "Ubicación" es requerido',
            'type.required' => 'El campo de "Tipo" es requerido',
            'schedule_id.required' => 'El campo de "Horario" es requerido'
        ];
    }
}
