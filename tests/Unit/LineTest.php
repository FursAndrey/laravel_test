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
				'lineLength' => 10,
				'voltLoss' => 0.45
			], 
			Line::getLineParams(16, 0, 'Cu', 10)
		);
	}
}
