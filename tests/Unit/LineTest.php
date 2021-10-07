<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Logic\Line;

class LineTest extends TestCase
{
	/** @return void */
	public function testLineParams() {
		$this->assertEquals(
			[
				'countParalelLine' => 1, 
				'iLine' => 19, 
				'iKabel' => 19, 
				'sLine' => 1.5, 
				'material' => 'Cu', 
				'lineLength' => 10
			], 
			Line::getLineParams(16, 'Cu', 10)
		);
	}
	
	/** @return void */
	public function testVoltLoss() {
		$this->assertEquals(0.45, Line::getVoltLoss(16, 0, 'Cu', 10));
	}
}
