<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CalcRequest;

use App\Http\Logic\CalcLogic;
use App\Http\Logic\ReferenceLogic;

class CalcController extends Controller
{
	public function submit(CalcRequest $req) {
		$power = $req['power'];
		$typeEO = $req['typeEO'];
		$typeProt = $req['typeProt'];
		$material = $req['material'];
		$lineLength = $req['lineLength'];

		$amperageEO = CalcLogic::amperage($power, $typeEO);
		$amperageProtection = CalcLogic::amperageProtection($amperageEO, $typeProt);
		$lineParams = CalcLogic::getLineParams($amperageProtection, $typeEO, $material, $lineLength);

		return view(
			'calc_result',
			[
				'systemData' => CalcLogic::getDataSystem(),
				'initialData' => [
					'power' => $power,
					'typeEO' => ReferenceLogic::getListTypeEO()[$typeEO],
					'typeProt'=> ReferenceLogic::getProtLiat()[$typeProt]
				],
				'result' => [
					'typeEO' => $typeEO,
					'amperageEO' => $amperageEO,
					'amperageProtection' => $amperageProtection,
					'lineParams' => $lineParams
				]
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
(не обязательно) git remote add origin https://github.com/FursAndrey/laravel_test.git
git branch -M main
git push -u origin main
*/