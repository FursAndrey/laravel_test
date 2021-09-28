<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Logic\CalcLogic;

class CalcLogicTest extends TestCase
{
	private const PROT_AB = 1;
	private const PROT_PP = 2;
	/** @return void */
	public function testAmperage()
	{
		//станки
		$this->assertEquals(15.5, CalcLogic::amperage(10, 2));
		//ПТО
		$this->assertEquals(28.1, CalcLogic::amperage(18.5, 17));
		$this->assertEquals(35.6, CalcLogic::amperage(18.5, 18));
		//сварка
		$this->assertEquals(28.9, CalcLogic::amperage(19, 19));
		$this->assertEquals(30.4, CalcLogic::amperage(20, 20));
		$this->assertEquals(31.9, CalcLogic::amperage(21, 21));
		$this->assertEquals(33.4, CalcLogic::amperage(22, 22));
		$this->assertEquals(34.9, CalcLogic::amperage(23, 23));
		//бытовое однофазное ЭО
		$this->assertEquals(5.7, CalcLogic::amperage(1, 25));
	}

	/** @return void */
	public function testAmperageProtection() {
		//автоматы
		$this->assertEquals(10, CalcLogic::amperageProtection(5, self::PROT_AB));
		$this->assertEquals(12.5, CalcLogic::amperageProtection(11, self::PROT_AB));
		$this->assertEquals(200, CalcLogic::amperageProtection(165, self::PROT_AB));
		$this->assertEquals(630, CalcLogic::amperageProtection(627.6, self::PROT_AB));
		$this->assertEquals(0, CalcLogic::amperageProtection(630.8, self::PROT_AB));
		//предохранители
		$this->assertEquals(32, CalcLogic::amperageProtection(15.8, self::PROT_PP));
		$this->assertEquals(125, CalcLogic::amperageProtection(62, self::PROT_PP));
		$this->assertEquals(630, CalcLogic::amperageProtection(313.8, self::PROT_PP));
		$this->assertEquals(0, CalcLogic::amperageProtection(315, self::PROT_PP));
	}
	
	/** @return void */
	public function testLineParams() {
		$this->assertEquals(
			[
				'countParalelLine' => 1, 
				'iLine' => 19, 
				'iKabel' => 19, 
				'sLine' => 1.5, 
				'material' => 'Cu', 
				'lineLength' => 10,
				'voltLoss' => 0.45
			], 
			CalcLogic::getLineParams(16, 0, 'Cu', 10)
		);
	}
}
