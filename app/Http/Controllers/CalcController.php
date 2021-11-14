<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalcRequest;
use App\Http\Logic\Calc;

class CalcController extends Controller
{
	public function submit(CalcRequest $request) {
		$arr_power = $request['power'];
		$arr_type_eo = $request['typeEO'];
		$arr_type_prot = $request['typeProt'];
		$arr_material = $request['material'];
		$arr_line_length = $request['lineLength'];

		if (
			count($arr_power) == count($arr_type_eo)
			&& count($arr_power) == count($arr_type_prot)
			&& count($arr_power) == count($arr_material)
			&& count($arr_power) == count($arr_line_length)
		) {
			for ($i = 0; $i < count($arr_power); $i++) { 
				$req[$i]['power'] = $arr_power[$i];
				$req[$i]['typeEO'] = $arr_type_eo[$i];
				$req[$i]['typeProt'] = $arr_type_prot[$i];
				$req[$i]['material'] = $arr_material[$i];
				$req[$i]['lineLength'] = $arr_line_length[$i];
			}
		} else {
			echo "Error";
			exit('!!!');
		}
		
		$result = Calc::startCalc($req);

		return view(
			'calc_result',
			[
				'result' => $result
			]
		);
	}
}
/*
//create a new repository on the command line
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/FursAndrey/laravel_test.git
git push -u origin main

//push an existing repository from the command line
git add .
git commit -m "loop calc"
git branch -M main
git push -u origin main
*/