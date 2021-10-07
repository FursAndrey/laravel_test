<?php
namespace App\Http\Logic;

use App\Http\Logic\ReferenceLogic;
use App\Http\Logic\Calc;

final class Line
{
	/** расчет кабельной линии
	 * 	@param float $I - рачетная сила тока для кабеля
	 * 	@param string $material - материал линии ('Cu' - медь, 'Al' - аллюминий)
	 * 	@param float $lineLength - длина линии
	 * 
	 * 	@return array - параметры линии 
	 * 					[
	 * 						'countParalelLine' => кол-во парал. кабелей,
	 * 						'iLine' => номинальный ток 1 кабеля,
	 * 						'sLine' => сечение 1 кабеля,
	 * 						'material' => материал кабеля
	 * 					]
	 */
	public static function getLineParams(
		float $I, 
		string $material = 'Cu', 
		float $lineLength = 10
	):array {
		$result = ReferenceLogic::getLineParams($I, $material);
		$result['material'] = $material;
		$result['lineLength'] = $lineLength;
		$result['iLine'] = $result['countParalelLine']*$result['iKabel'];
		
		return $result;
	}

	/** расчет потери напряжения кабельной линии
	 * 	@param float $I - рачетная сила тока оборудования
	 * 	@param int $typeEO - тип ЭО
	 * 	@param string $material - материал линии ('Cu' - медь, 'Al' - аллюминий)
	 * 	@param float $lineLength - длина линии
	 * 
	 * 	@return float - потеря напряжения в %
	 */
	public static function getVoltLoss(
		float $I, 
		float $typeEO, 
		string $material = 'Cu', 
		float $lineLength = 10
	):float {
		$result = ReferenceLogic::getLineParams($I, $material);
		//переводим из `м` в `км`
		$lineLength = $lineLength / 1000;

		$cos = ReferenceLogic::getCosThisEO($typeEO);
		$resist = ReferenceLogic::getResistance($result['sLine'], $material);

		if (Calc::is_1F($typeEO)) {
			return self::getVoltLoss1F($I, $cos, $resist, $lineLength, $result['countParalelLine']);
		} else {
			return self::getVoltLoss3F($I, $cos, $resist, $lineLength, $result['countParalelLine']);
		}
	}

	/**	потеря напряжения в 3-фазной сети
	 * 	@param float $I - рачетная сила тока для кабеля
	 * 	@param float $cos - коэффициент мощности
	 * 	@return array - массив сопротивлений ['R' => ..., 'X' => ...]
	 * 	@param float $L - длина линии
	 * 	@param int $countlLine - кол-во парал. кабелей
	 * 
	 * 	@return float - потеря напряжения в %
	 */
	private static function getVoltLoss3F(
		float $I, 
		float $cos,
		array $r,
		float $L,
		int $countlLine
	):float {
		//переводим из `кВ` в `В`
		$U = Calc::VOLTAGE_3F * 1000;
		$sin = sin(acos($cos));
		$voltLoss = (sqrt(3) * 100 * $I * $L * ($r['R']*$cos + $r['X']*$sin)) / ($U * $countlLine);
		return round($voltLoss, 2);
	}
	
	/**	потеря напряжения в 3-фазной сети
	 * 	@param float $I - рачетная сила тока для кабеля
	 * 	@param float $cos - коэффициент мощности
	 * 	@return array - массив сопротивлений ['R' => ..., 'X' => ...]
	 * 	@param float $L - длина линии
	 * 	@param int $countlLine - кол-во парал. кабелей
	 * 
	 * 	@return float - потеря напряжения в %
	 */
	private static function getVoltLoss1F(
		float $I, 
		float $cos,
		array $r,
		float $L,
		int $countlLine
	):float {
		//переводим из `кВ` в `В`
		$U = Calc::VOLTAGE_1F * 1000;
		$sin = sin(acos($cos));
		$voltLoss = (2 * 100 * $I * $L * ($r['R']*$cos + $r['X']*$sin)) / ($U*$cos * $countlLine);
		return round($voltLoss, 2);
	}
}