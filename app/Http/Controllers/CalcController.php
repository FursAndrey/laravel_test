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

		$amperageEO = CalcLogic::amperage($power, $typeEO);
		$amperageProtection = CalcLogic::amperageProtection($amperageEO, $typeProt);

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
					'amperageEO' => $amperageEO,
					'amperageProtection' => $amperageProtection
				]
			]
		);
	}
}
