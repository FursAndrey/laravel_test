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
			'calc.*.power'=>'required|numeric',
			'calc.*.typeEO'=>'required|integer',
			'calc.*.typeProt'=>'required|integer|regex:/^[1,2]$/',
			'calc.*.material'=>'required|max:2|regex:/^(Cu)?(Al)?$/',
			'calc.*.lineLength'=>'required|numeric'
		];
	}

    public function messages()
	{
		return [
			'calc.*.power.required' => 'Поле `мощность оборудования` является обязательным',
			'calc.*.power.numeric' => 'Поле `мощность оборудования` может содержать только цифры 
				и 1 точку как отделитель дробной части',
			'calc.*.typeEO.required' => 'Поле `тип оборудования` является обязательным',
			'calc.*.typeEO.integer' => 'Поле `тип оборудования` может содержать только цифры',
			'calc.*.typeProt.required' => 'Поле `тип оборудования` является обязательным',
			'calc.*.typeProt.integer' => 'Поле `тип оборудования` может содержать только цифры',
			'calc.*.typeProt.regex' => 'Поле `тип оборудования` может содержать только цифры 1 или 2',
			'calc.*.material.required' => 'Поле `Материал линии` является обязательным',
			'calc.*.material.max' => 'Поле `Материал линии` не может быть более 2 символов',
			'calc.*.material.regex' => 'Поле `Материал линии` может содержать только Cu,Al',
			'calc.*.lineLength.required' => 'Поле `длина линии` является обязательным',
			'calc.*.lineLength.numeric' => 'Поле `длина линии` может содержать только цифры 
				и 1 точку как отделитель дробной части'
		];
	}
}
