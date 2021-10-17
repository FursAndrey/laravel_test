<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Http\Logic\Calc;

class CalcTest extends TestCase
{
	private const PROT_AB = 1;
	private const PROT_PP = 2;
	
	public function testStartCalc() {
		$inptData = [
			'0' => [
				'power' => 12,
				'typeEO' => 0,
				'typeProt' => self::PROT_AB,
				'material' => 'Cu',
				'lineLength' => 23
			]
		];
		$outptData = [
			'systemData' => [
				'systemVolt' => '0.38/0.22'
			],
			'initialData' => [
				'0' => [
					'power' => 12,
					'typeEOText' => 'Металлорежущие станки мелкосерийного производства',
					'typeProtText' => 'Автоматический выключатель'
				]
			],
			'calcResult' => [
				'0' => [
					'typeEO' => 0,
					'amperageEO' => 18.8,
					'amperageProtection' => 20,
					'lineParams' => [
						'countParalelLine' => 1,
						'iKabel' => 25,
						'sLine' => 2.5,
						'material' => 'Cu',
						'lineLength' => 23,
						'iLine' => 25,
						'voltLoss' => 1.21
					]
				]
			]
		];

		$this->assertEquals($outptData, Calc::startCalc($inptData));
	}

	public function testStartCalcLoop() {
		$inptData = [
			'0' => [
				'power' => 12,
				'typeEO' => 5,
				'typeProt' => self::PROT_AB,
				'material' => 'Cu',
				'lineLength' => 23
			],
			'1' => [
				'power' => 32,
				'typeEO' => 14,
				'typeProt' => self::PROT_AB,
				'material' => 'Al',
				'lineLength' => 12
			]
		];
		$outptData = [
			'systemData' => [
				'systemVolt' => '0.38/0.22'
			],
			'initialData' => [
				'0' => [
					'power' => 12,
					'typeEOText' => 'Автоматические поточные линии',
					'typeProtText' => 'Автоматический выключатель'
				],
				'1' => [
					'power' => 32,
					'typeEOText' => 'Вентиляторы, санитарно-гигиенические вентиляторы',
					'typeProtText' => 'Автоматический выключатель'
				]
			],
			'calcResult' => [
				'0' => [
					'typeEO' => 5,
					'amperageEO' => 20.9,
					'amperageProtection' => 25,
					'lineParams' => [
						'countParalelLine' => 1,
						'iKabel' => 25,
						'sLine' => 2.5,
						'material' => 'Cu',
						'lineLength' => 23,
						'iLine' => 25,
						'voltLoss' => 1.24
					]
				],
				'1' => [
					'typeEO' => 14,
					'amperageEO' => 54.9,
					'amperageProtection' => 63,
					'lineParams' => [
						'countParalelLine' => 1,
						'iKabel' => 75,
						'sLine' => 25,
						'material' => 'Al',
						'lineLength' => 12,
						'iLine' => 75,
						'voltLoss' => 0.51
					]
				]
			]
		];

		$this->assertEquals($outptData, Calc::startCalc($inptData));
	}
}
