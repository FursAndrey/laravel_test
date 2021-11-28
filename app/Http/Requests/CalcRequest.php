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
			'power.*'=>'required|numeric',
			'typeEO.*'=>'required|integer',
			'typeProt.*'=>'required|integer|regex:/^[1,2]$/',
			'material.*'=>'required|max:2|regex:/^(Cu)?(Al)?$/',
			'lineLength.*'=>'required|numeric'
		];
	}

    public function messages()
	{
		return [
			'power.*.required' => 'Поле `мощность оборудования` является обязательным',
			'power.*.numeric' => 'Поле `мощность оборудования` может содержать только цифры 
				и 1 точку как отделитель дробной части',
			'typeEO.*.required' => 'Поле `тип оборудования` является обязательным',
			'typeEO.*.integer' => 'Поле `тип оборудования` может содержать только цифры',
			'typeProt.*.required' => 'Поле `тип оборудования` является обязательным',
			'typeProt.*.integer' => 'Поле `тип оборудования` может содержать только цифры',
			'typeProt.*.regex' => 'Поле `тип оборудования` может содержать только цифры 1 или 2',
			'material.*.required' => 'Поле `Материал линии` является обязательным',
			'material.*.max' => 'Поле `Материал линии` не может быть более 2 символов',
			'material.*.regex' => 'Поле `Материал линии` может содержать только Cu,Al',
			'lineLength.*.required' => 'Поле `длина линии` является обязательным',
			'lineLength.*.numeric' => 'Поле `длина линии` может содержать только цифры 
				и 1 точку как отделитель дробной части'
		];
	}
}
