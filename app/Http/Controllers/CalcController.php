<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalcRequest;

use App\Http\Logic\Calc;

class CalcController extends Controller
{
	public function submit(CalcRequest $req) {
		$power = $req['power'];
		$typeEO = $req['typeEO'];
		$typeProt = $req['typeProt'];
		$material = $req['material'];
		$lineLength = $req['lineLength'];
		
		return view(
			'calc_result',
			[
				'initialData' => Calc::getInitialData($power, $typeEO, $typeProt),
				'result' => Calc::getCalcResult($power, $typeEO, $typeProt, $material, $lineLength)
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
git commit -m "test and validation correction"
git branch -M main
git push -u origin main
*/