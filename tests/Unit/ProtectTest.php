<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Logic\Protect;

class ProtectTest extends TestCase
{
	private const PROT_AB = 1;
	private const PROT_PP = 2;
	
	/** @return void */
	public function testAmperageProtection() {
		//автоматы
		$this->assertEquals(10, Protect::amperageProtection(5, self::PROT_AB, 1));
		$this->assertEquals(12.5, Protect::amperageProtection(11, self::PROT_AB, 1));
		$this->assertEquals(12.5, Protect::amperageProtection(11, self::PROT_AB, 26));
		$this->assertEquals(200, Protect::amperageProtection(165, self::PROT_AB, 1));
		$this->assertEquals(630, Protect::amperageProtection(627.6, self::PROT_AB, 1));
		$this->assertEquals(0, Protect::amperageProtection(630.8, self::PROT_AB, 1));
		//предохранители (3Ф)
		$this->assertEquals(32, Protect::amperageProtection(15.8, self::PROT_PP, 1));
		$this->assertEquals(125, Protect::amperageProtection(62, self::PROT_PP, 1));
		$this->assertEquals(630, Protect::amperageProtection(313.8, self::PROT_PP, 1));
		$this->assertEquals(0, Protect::amperageProtection(315, self::PROT_PP, 1));
		//предохранители (1Ф)
		$this->assertEquals(32, Protect::amperageProtection(15.8, self::PROT_PP, 26));
		$this->assertEquals(315, Protect::amperageProtection(313.8, self::PROT_PP, 26));
	}
}
