<?php
namespace App\Http\Logic;

use App\Http\Logic\ReferenceLogic;
use App\Http\Logic\Calc;

final class Protect
{	
	/**	выбор аппарата защиты
	 * 	@param float $I- номинальная сила тока ЭО
	 * 	@param int $typeProt - тип аппарата защиты
	 * 	@param int $typeEO - тип ЭО
	 * 
	 * 	@return float - номинальная сила тока аппарата защиты
	 */
	public static function amperageProtection(float $I, int $typeProt, int $typeEO):float {
		if ($typeProt == 1) {
			//расчет тока автоматического выключателя
			return ReferenceLogic::getAmperAB($I);
		} elseif ($typeProt == 2) {
			//расчет тока плавкого предохранителя
			
			//расчет пикового (пускового) тока
			if (Calc::is_1F($typeEO)) {
				$K_PUSK = 1*2.5;
			} else {
				$K_PUSK = 5;
			}
			$Ipusk = $I*$K_PUSK;
			return ReferenceLogic::getAmperPP($Ipusk);
		}
	}
}