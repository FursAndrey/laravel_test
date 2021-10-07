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

	/**	получить исходные данные расчета
	 * 	@param float $power - номинальная активкая мощность ЭО
	 * 	@param int $typeEO - тип ЭО
	 * 	@param int $typeProt - тип аппарата защиты
	 * 
	 * 	@return array - 'systemVolt' => string, 'power' => float, 'typeEO' => string, 'typeProt'=> string
	 */
	public static function getInitialData(float $power, int $typeEO, int $typeProt):array {
		return [
			'systemVolt' => round(self::VOLTAGE_3F,2).'/'.round(self::VOLTAGE_1F,2),
			'power' => $power,
			'typeEOText' => ReferenceLogic::getListTypeEO()[$typeEO],
			'typeProtText'=> ReferenceLogic::getProtList()[$typeProt]
		];
	}

	/**	получить исходные данные расчета
	 * 	@param float $power - номинальная активкая мощность ЭО
	 * 	@param int $typeEO - тип ЭО
	 * 	@param int $typeProt - тип аппарата защиты
	 * 	@param string $material - материал линии ('Cu' - медь, 'Al' - аллюминий)
	 * 	@param float $lineLength - длина линии
	 * 
	 * 	@return array - 'amperageEO' => float, 'amperageProtection' => float, 'lineParams' => array[]
	 */
	public static function getCalcResult(
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