<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalcRequest;
use App\Http\Logic\Calc;

class CalcController extends Controller
{
	public function submit(CalcRequest $request) {
		$req = $request['calc'];
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