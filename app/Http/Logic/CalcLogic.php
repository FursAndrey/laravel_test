<?php
namespace App\Http\Logic;

use App\Http\Logic\ReferenceLogic;

final class CalcLogic
{
	/** @var float - номинальное напряжение 3-х фазной сети */
	private const VOLTAGE_3F = 0.38;
	/** @var float - номинальное напряжение однофазной сети */
	private const VOLTAGE_1F = self::VOLTAGE_3F / 1.73;

	/**	получить параметры системы для вывода результата (напряжение 3Ф/1Ф) 
	 * 	@return string - напряжение 3Ф/1Ф
	 */
	public static function getDataSystem():string {
		return round(self::VOLTAGE_3F,2).'/'.round(self::VOLTAGE_1F,2);
	}

	/** расчет силы тока ЭО
	 * 	@param float $power - номинальная активкая мощность ЭО
	 * 	@param int $typeEO - тип ЭО
	 * 
	 * 	@return float - номинальная сила тока
	 */
	public static function amperage(float $power, float $typeEO):float {

		//типы особого оборудования
		$pto25 = 17;
		$pto40 = 18;
		$svarka = [19, 20, 21, 22, 23];

		if (in_array($typeEO, [$pto25, $pto40])) {
			//задаем продолжительность включения в процентах
			$cos = ReferenceLogic::getCosThisEO($typeEO);

			if ($typeEO == $pto25) $pv = 0.25;
			elseif ($typeEO == $pto40) $pv = 0.4;
			//расчет для ПТО
			$amperage = self::amperagePTU($power, $cos, $pv);
		} elseif (in_array($typeEO, $svarka)) {
			//расчет для сварочного оборудования
			$amperage = self::amperageSvarka($power);
		} elseif (self::is_1F($typeEO)) {
			//расчет для бытового однофазного оборудования
			$cos = ReferenceLogic::getCosThisEO($typeEO);

			$amperage = self::amperage1F($power, $cos);
		} else {
			//расчет для всего кроме ПТО, сварки и однофазного ЭО
			$Ku = ReferenceLogic::getKuThisEO($typeEO);
			$cos = ReferenceLogic::getCosThisEO($typeEO);

			$amperage = self::amperageEo($power, $Ku, $cos);
		}
		return $amperage;
	}

	/**	расчет силы тока станков, печей
	 * 	@param float $P - номинальная активкая мощность станков, печей
	 * 	@param float $Ku - коэффициент использования станков, печей
	 * 	@param float $cos - коэффициент мощности станков, печей
	 * 
	 * 	@return float - номинальная сила тока
	 */
	private static function amperageEo(float $P, float $Ku, float $cos):float {
		$Qp = $P*tan(acos($cos))*$Ku;
		$Sp = sqrt($Qp*$Qp + $P*$P);
		return round($Sp/(sqrt(3)*self::VOLTAGE_3F), 1);
	}
	
	/**	расчет силы тока ПТО
	 * 	@param float $P - номинальная активкая мощность ПТО
	 * 	@param float $cos - коэффициент мощности ПТО
	 * 	@param float $PV - продолжительность включения ПТО
	 * 
	 * 	@return float - номинальная сила тока
	 */
	private static function amperagePtu(float $P, float $cos, float $PV = 100):float {
		$Pp = $P*sqrt($PV);
		return round($Pp/(sqrt(3)*self::VOLTAGE_3F*$cos), 1);
	}
	
	/**	расчет силы тока сварочного оборудования
	 * 	@param float $S - номинальная полная мощность сварочного оборудования
	 * 
	 * 	@return float - номинальная сила тока
	 */
	private static function amperageSvarka(float $S):float {
		return round($S/(sqrt(3)*self::VOLTAGE_3F), 1);
	}

	/**	расчет силы тока однофазного бытового оборудования
	 * 	@param float $P - номинальная мощность однофазного бытового оборудования
	 * 	@param int $typeEO - тип ЭО
	 * 	@param float $cos - коэффициент мощности
	 * 
	 * 	@return float - номинальная сила тока
	 */
	private static function amperage1F(float $P, float $cos):float {
		return round($P/(self::VOLTAGE_1F*$cos), 1);
	}
	
	/**	выбор аппарата защиты
	 * 	@param float $I- номинальная сила тока ЭО
	 * 	@param int $typeProt - тип аппарата защиты
	 * 
	 * 	@return float - номинальная сила тока аппарата защиты
	 */
	public static function amperageProtection(float $I, int $typeProt):float {
		if ($typeProt == 1) {
			//расчет тока автоматического выключателя
			return ReferenceLogic::getAmperAB($I);
		} elseif ($typeProt == 2) {
			//расчет тока плавкого предохранителя
			
			//расчет пикового (пускового) тока
			$K_PUSK = 5;
			$Ipusk = $I*$K_PUSK;
			return ReferenceLogic::getAmperPP($Ipusk);
		}
	}

	/** расчет кабельной линии
	 * 	@param float $I - рачетная сила тока для кабеля
	 * 	@param string $material - материал линии ('Cu' - медь, 'Al' - аллюминий)
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
		float $typeEO, 
		string $material = 'Cu', 
		float $lineLength = 10
	):array {		
		$cos = ReferenceLogic::getCosThisEO($typeEO);

		$result = ReferenceLogic::getLineParams($I, $material);
		$result['material'] = $material;
		//сохраняем длину в `м` для вывода результата
		$result['lineLength'] = $lineLength;
		$result['iLine'] = $result['countParalelLine']*$result['iKabel'];
		
		//переводим из `м` в `км`
		$lineLength = $lineLength / 1000;

		$resist = ReferenceLogic::getResistance($result['sLine'], $result['material']);

		if (self::is_1F($typeEO)) {
			$result['voltLoss'] = self::getVoltLoss1F($I, $cos, $resist, $lineLength, $result['countParalelLine']);
		} else {
			$result['voltLoss'] = self::getVoltLoss3F($I, $cos, $resist, $lineLength, $result['countParalelLine']);
		}
		
		return $result;
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
		$U = self::VOLTAGE_3F * 1000;
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
		$U = self::VOLTAGE_1F * 1000;
		$sin = sin(acos($cos));
		$voltLoss = (2 * 100 * $I * $L * ($r['R']*$cos + $r['X']*$sin)) / ($U*$cos * $countlLine);
		return round($voltLoss, 2);
	}

	/**	проверка, является ли ЭО 1-фазным
	 * 	@param int $typeEO - тип ЭО
	 * 
	 * 	@return bool - да/нет
	*/
	private static function is_1F($typeEO):bool {
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