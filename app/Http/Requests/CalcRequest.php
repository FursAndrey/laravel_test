<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalcRequest extends FormRequest
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
            'power'=>'required|numeric',
            'lineLength'=>'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'power.required' => 'Поле `мощность оборудования` является обязательным',
            'power.numeric' => 'Поле `мощность оборудования` может содержать только цифры 
                и 1 точку как отделитель дробной части',
            'lineLength.required' => 'Поле `длина линии` является обязательным',
            'lineLength.numeric' => 'Поле `длина линии` может содержать только цифры 
                и 1 точку как отделитель дробной части'
        ];
    }
}
