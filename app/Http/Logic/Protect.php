<?php
namespace App\Http\Logic;

use App\Http\Logic\ReferenceLogic;

final class Protect
{	
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
}