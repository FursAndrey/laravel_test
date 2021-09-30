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
	/**
	 * @return void
	 */
	public function testGetInitialData()
	{
		$this->assertEquals(
			[
				'systemVolt' => '0.38/0.22',
				'power' => 15,
				'typeEOText' => 'Металлорежущие станки мелкосерийного производства',
				'typeProtText' => 'Автоматический выключатель'
			], 
			Calc::getInitialData(15, 0, self::PROT_AB)
		);
		$this->assertEquals(
			[
				'systemVolt' => '0.38/0.22',
				'power' => 100,
				'typeEOText' => 'Насосы, компрессоры, двигатель-генераторы',
				'typeProtText' => 'Автоматический выключатель'
			], 
			Calc::getInitialData(100, 12, self::PROT_AB)
		);
		$this->assertEquals(
			[
				'systemVolt' => '0.38/0.22',
				'power' => 10,
				'typeEOText' => 'Компьютерное оборудование',
				'typeProtText' => 'Плавкий предохранитель'
			], 
			Calc::getInitialData(10, 26, self::PROT_PP)
		);
	}
	
	public function testGetCalcResult()
	{
		$this->assertEquals(
			[
				'typeEO' => 0,
				'amperageEO' => 23.5,
				'amperageProtection' => 25,
				'lineParams' => [
						'countParalelLine' => 1,
						'iKabel' => 25,
						'sLine' => 2.5,
						'material' => 'Cu',
						'lineLength' => 10,
						'iLine' => 25,
						'voltLoss' => 0.42
					]
			], 
			Calc::getCalcResult(15, 0, self::PROT_AB, 'Cu', 10)
		);
		$this->assertEquals(
			[
				'typeEO' => 12,
				'amperageEO' => 165.6,
				'amperageProtection' => 200,
				'lineParams' => [
						'countParalelLine' => 2,
						'iKabel' => 110,
						'sLine' => 50,
						'material' => 'Al',
						'lineLength' => 34,
						'iLine' => 220,
						'voltLoss' => 0.93
					]
			], 
			Calc::getCalcResult(100, 12, self::PROT_AB, 'Al', 34)
		);
		$this->assertEquals(
			[
				'typeEO' => 26,
				'amperageEO' => 65,
				'amperageProtection' => 160,
				'lineParams' => [
						'countParalelLine' => 1,
						'iKabel' => 180,
						'sLine' => 70,
						'material' => 'Cu',
						'lineLength' => 34,
						'iLine' => 180,
						'voltLoss' => 1.74
					]
			], 
			Calc::getCalcResult(10, 26, self::PROT_PP, 'Cu', 34)
		);
	}
}
