<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalcRequest;
use App\Http\Logic\Calc;

class CalcController extends Controller
{
	public function submit(CalcRequest $request) {
		$req = $request['calc'];

		$power = $req[0]['power'];
		$typeEO = $req[0]['typeEO'];
		$typeProt = $req[0]['typeProt'];
		$material = $req[0]['material'];
		$lineLength = $req[0]['lineLength'];
		
		$initialData = Calc::getInitialData($power, $typeEO, $typeProt);
		$result = Calc::getCalcResult($power, $typeEO, $typeProt, $material, $lineLength);

		return view(
			'calc_result',
			[
				'initialData' => $initialData,
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
git commit -m "change request and validation"
git branch -M main
git push -u origin main
*/