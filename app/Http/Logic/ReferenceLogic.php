<?php
namespace App\Http\Logic;

use App\Http\Logic\ReferenceBook; 
final class ReferenceLogic extends ReferenceBook
{	
	/** Получить список типов ЭО с их ID
	 *  @return array $res - массив типов ЭО в формате [0=>'...', 1=>'...', 2=>'...' и т.д.]
	 */
	public static function getListTypeEO(): array {
		for ($i = 0; $i < count(self::EO); $i++) { 
			$res[$i] = self::EO[$i]['name'];
		}
		return $res;
	}
	
	/** Получить Ки конкретного ЭО
	 *  @param int $id - идентификатор ЭО
	 * 
	 *  @return float - коэф. использования
	 */
	public static function getKuThisEO(int $id): float {
		return self::EO[$id]['Ku'];
	}
	
	/** Получить коэф. мощности конкретного ЭО
	 *  @param int $id - идентификатор ЭО
	 * 
	 *  @return float - коэф. мощности
	 */
	public static function getCosThisEO(int $id): float {
		return self::EO[$id]['COS'];
	}

	/**	Получить номинальный ток автоматического выключателя
	 * 	@param float $I- номинальная сила тока ЭО
	 * 
	 * 	@return float - номинальная сила тока АВ
	 */
	public static function getAmperAB(float $I):float {
		for ($i = 0; $i < count(self::I_AB); $i++) {
			if (self::I_AB[$i] > $I) {
				return self::I_AB[$i];
			}
		}
		return 0;
	}
	
	/**	Получить номинальный ток плавкого предохранителя
	 * 	@param float $I- номинальная сила тока ЭО
	 * 
	 * 	@return float - номинальная сила тока ПП
	 */
	public static function getAmperPP(float $I):float {
		$Ipp = $I/1.6;
		for ($i = 0; $i < count(self::I_PP); $i++) {
			if (self::I_PP[$i] > $Ipp) {
				return self::I_PP[$i];
			}
		}
		return 0;
	}

	/**	Получить список типов аппаратов защиты
	 * 	@return array - список типов аппаратов защиты
	 */
	public static function getProtLiat():array {
		return self::TYPE_PROT;
	}
}