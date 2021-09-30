<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Logic\Amperage;

class AmperageTest extends TestCase
{
	/** @return void */
	public function testAmperage()
	{
		//станки
		$this->assertEquals(15.5, Amperage::amperage(10, 2));
		//ПТО
		$this->assertEquals(28.1, Amperage::amperage(18.5, 17));
		$this->assertEquals(35.6, Amperage::amperage(18.5, 18));
		//сварка
		$this->assertEquals(28.9, Amperage::amperage(19, 19));
		$this->assertEquals(30.4, Amperage::amperage(20, 20));
		$this->assertEquals(31.9, Amperage::amperage(21, 21));
		$this->assertEquals(33.4, Amperage::amperage(22, 22));
		$this->assertEquals(34.9, Amperage::amperage(23, 23));
		//бытовое однофазное ЭО
		$this->assertEquals(5.7, Amperage::amperage(1, 25));
	}

}
