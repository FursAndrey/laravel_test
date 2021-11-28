<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalcRequest;
use App\Http\Logic\Calc;

class CalcController extends Controller
{
	public function submit(CalcRequest $request) {
		if (
			count($request['power']) == count($request['typeEO'])
			&& count($request['power']) == count($request['typeProt'])
			&& count($request['power']) == count($request['material'])
			&& count($request['power']) == count($request['lineLength'])
		) {
			for ($i = 0; $i < count($request['power']); $i++) {
				$req[$i]['power'] = $request['power'][$i];
				$req[$i]['typeEO'] = $request['typeEO'][$i];
				$req[$i]['typeProt'] = $request['typeProt'][$i];
				$req[$i]['material'] = $request['material'][$i];
				$req[$i]['lineLength'] = $request['lineLength'][$i];
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