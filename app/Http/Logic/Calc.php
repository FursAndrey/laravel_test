<?php
namespace App\Http\Logic;

use App\Http\Logic\ReferenceLogic;
use App\Http\Logic\Amperage;
use App\Http\Logic\Protect;
use App\Http\Logic\Line;

final class Calc
{
	/** @var float - номинальное напряжение 3-х фазной сети */
	public const VOLTAGE_3F = 0.38;
	/** @var float - номинальное напряжение однофазной сети */
	public const VOLTAGE_1F = self::VOLTAGE_3F / 1.73;

	/**	запуск расчетов
	 * 	@param array - массив входных данных в формате 
	 * 	[0] => [
	 * 		'power'=?,
	 * 		'typeEO'=?,
	 * 		'typeProt'=?,
	 * 		'material'=?,
	 * 		'lineLength'=?
	 * 	],
	 * 	[1] => [...],
	 * 	...
	 * 
	 * 	@return array - массив выходных данных в формате
	 * 	[
	 * 		'systemData' => ['systemVolt' = string],
	 * 		'initialData' => [
	 * 			[0] => [
	 * 				'power' = float,
	 * 				'typeEO' => string, 
	 * 				'typeProt'=> string
	 * 			],
	 * 			[1] => [...],
	 * 			...
	 * 		],
	 * 		'calcResult' => [
	 * 			[0] => [
	 * 				'amperageEO' => float, 
	 * 				'amperageProtection' => float, 
	 * 				'lineParams' => array[]
	 * 			],
	 * 			[1] => [...],
	 * 			...
	 * 		]
	 * 	]
	 */
	public static function startCalc(array $req):array {
		$systemData = self::getSystemData();
		$generalPower = 0;
		for ($numOfEo = 0; $numOfEo < count($req); $numOfEo++) { 
			$power = $req[$numOfEo]['power'];
			$typeEO = $req[$numOfEo]['typeEO'];
			$typeProt = $req[$numOfEo]['typeProt'];
			$material = $req[$numOfEo]['material'];
			$lineLength = $req[$numOfEo]['lineLength'];

			$initialData[$numOfEo] = self::getInitialData($power, $typeEO, $typeProt);
			$result[$numOfEo] = self::getCalcResult($power, $typeEO, $typeProt, $material, $lineLength);
			
			$generalPower += $power;
		}

		return [
			'systemData' => $systemData,
			'initialData' => $initialData,
			'calcResult' => $result,
			'general' => $generalPower
		];
	}

	/**	получить исходные данные расчета
	 * 	@param float $power - номинальная активкая мощность ЭО
	 * 	@param int $typeEO - тип ЭО
	 * 	@param int $typeProt - тип аппарата защиты
	 * 
	 * 	@return array - 'power' => float, 'typeEO' => string, 'typeProt'=> string
	 */
	private static function getInitialData(float $power, int $typeEO, int $typeProt):array {
		return [
			'power' => $power,
			'typeEOText' => ReferenceLogic::getListTypeEO()[$typeEO],
			'typeProtText'=> ReferenceLogic::getProtList()[$typeProt]
		];
	}

	/**	получить общие данные для системы
	 * 	@return array - 'systemVolt' => string
	 */
	private static function getSystemData():array {
		return [
			'systemVolt' => round(self::VOLTAGE_3F,2).'/'.round(self::VOLTAGE_1F,2)
		];
	}

	/**	получить результаты расчета
	 * 	@param float $power - номинальная активкая мощность ЭО
	 * 	@param int $typeEO - тип ЭО
	 * 	@param int $typeProt - тип аппарата защиты
	 * 	@param string $material - материал линии ('Cu' - медь, 'Al' - аллюминий)
	 * 	@param float $lineLength - длина линии
	 * 
	 * 	@return array - 'amperageEO' => float, 'amperageProtection' => float, 'lineParams' => array[]
	 */
	private static function getCalcResult(
		float $power, 
		int $typeEO, 
		int $typeProt, 
		string $material, 
		float $lineLength
	):array {		
		$amperageEO = Amperage::amperage($power, $typeEO);
		$amperageProtection = Protect::amperageProtection($amperageEO, $typeProt, $typeEO);
		$lineParams = Line::getLineParams($amperageProtection, $material, $lineLength);
		$lineParams['voltLoss'] = line::getVoltLoss($amperageEO, $typeEO, $material, $lineLength);

		return [
			'typeEO' => $typeEO /* для настройки тестов */,
			'amperageEO' => $amperageEO,
			'amperageProtection' => $amperageProtection,
			'lineParams' => $lineParams
		];
	}
	
	/**	проверка, является ли ЭО 1-фазным
	 * 	@param int $typeEO - тип ЭО
	 * 
	 * 	@return bool - да/нет
	*/
	public static function is_1F($typeEO):bool {
		$eo1f = [25, 26, 27, 28, 29];
		if (in_array($typeEO, $eo1f)) {
			return true;
		} else {
			return false;
		}		
	}
}

/*
#create test file
php artisan make:test CalcLogicTest
php artisan make:test CalcLogicTest --unit

#start tests
php artisan test
*/