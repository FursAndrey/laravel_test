<?php
namespace App\Http\Logic;

use App\Http\Logic\ReferenceLogic;
use App\Http\Logic\Calc;

final class Amperage
{
	/** расчет силы тока ЭО
	 * 	@param float $power - номинальная активкая мощность ЭО
	 * 	@param int $typeEO - тип ЭО
	 * 
	 * 	@return float - номинальная сила тока
	 */
	public static function amperage(float $power, int $typeEO):float {
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
		} elseif (Calc::is_1F($typeEO)) {
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
		return round($Sp/(sqrt(3)*Calc::VOLTAGE_3F), 1);
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
		return round($Pp/(sqrt(3)*Calc::VOLTAGE_3F*$cos), 1);
	}
	
	/**	расчет силы тока сварочного оборудования
	 * 	@param float $S - номинальная полная мощность сварочного оборудования
	 * 
	 * 	@return float - номинальная сила тока
	 */
	private static function amperageSvarka(float $S):float {
		return round($S/(sqrt(3)*Calc::VOLTAGE_3F), 1);
	}

	/**	расчет силы тока однофазного бытового оборудования
	 * 	@param float $P - номинальная мощность однофазного бытового оборудования
	 * 	@param int $typeEO - тип ЭО
	 * 	@param float $cos - коэффициент мощности
	 * 
	 * 	@return float - номинальная сила тока
	 */
	private static function amperage1F(float $P, float $cos):float {
		return round($P/(Calc::VOLTAGE_1F*$cos), 1);
	}
}