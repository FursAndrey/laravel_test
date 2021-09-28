<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Http\Logic\CalcLogic;
use App\Http\Logic\ReferenceLogic;

class CalcTest extends TestCase
{
	private const PROT_AB = 1;
	private const PROT_PP = 2;
	/**
	 * @return void
	 */
	public function testCalculate()
	{
		$this->assertEquals(21.2, CalcLogic::amperage(13.5, 0));
		$this->assertEquals(10, CalcLogic::amperageProtection(5, self::PROT_AB));
		$this->assertEquals(32, CalcLogic::amperageProtection(15.7, self::PROT_PP));
	}
}
