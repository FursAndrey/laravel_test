<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Logic\CalcLogic;

class CalcLogicTest extends TestCase
{
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
		$this->assertEquals(10, CalcLogic::amperageProtection(5, 1));
		$this->assertEquals(12.5, CalcLogic::amperageProtection(11, 1));
		$this->assertEquals(0, CalcLogic::amperageProtection(165, 1));
		//предохранители
		$this->assertEquals(50, CalcLogic::amperageProtection(15.7, 2));
		$this->assertEquals(0, CalcLogic::amperageProtection(51.8, 2));
	}
	
	/** @return void */
	public function testLineParams() {
		$this->assertEquals(
			['countParalelLine' => 1, 'iLine' => 19, 'sLine' => 1.5, 'material' => 'Cu'], 
			CalcLogic::getLineParams(16, 'Cu')
		);
	}
}
