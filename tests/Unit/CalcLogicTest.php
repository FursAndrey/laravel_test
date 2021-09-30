<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Logic\Calc;

class CalcLogicTest extends TestCase
{	
	/** @return void */
	public function testIs_1f() {
		$this->assertEquals(false, Calc::is_1F(5));
		$this->assertEquals(true, Calc::is_1F(25));
	}
}
