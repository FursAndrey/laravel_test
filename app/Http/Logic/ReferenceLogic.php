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
		$Ipp = $I/2.5;
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

	/** расчет кабельной линии
	 * 	@param float $I - рачетная сила тока для кабеля
	 * 	@param string $material - материал линии ('Cu' - медь, 'Al' - аллюминий)
	 * 
	 * 	@return array - параметры линии 
	 * 					[
	 * 						'countParalelLine' => кол-во парал. кабелей,
	 * 						'iLine' => номинальный ток 1 кабеля,
	 * 						'sLine' => сечение 1 кабеля
	 * 					]
	 */
	public static function getLineParams(float $I, string $material = 'Cu'):array {
		//подбираем сечение кабеля по току - минимальный больше номинального тока ЭО
		//цикл для расчета количества паралельных проводников
		$countParalelLine = 0;
		do {
			++$countParalelLine;
			if ($countParalelLine == 4) break;
			//подбираем сечение кабеля по току - минимальный больше номинального тока ЭО
			$index = 0;
			//цикл для выбора сечения проводника
			do {
				if ($index == count(self::KABEL_PVH)) break;
				$iKabel = self::KABEL_PVH[$index][$material];

				++$index;

			} while ($I/$countParalelLine > $iKabel);
			--$index;

		} while ($I > self::KABEL_PVH[$index][$material] * $countParalelLine);

		return [
			'countParalelLine' => $countParalelLine, 
			'iKabel' => $iKabel, 
			'sLine' => self::KABEL_PVH[$index]['s']
		];
	}
	
	/**	получить погонные сопротивления для проводов и кабелей
	 * 	@param float $sLine - сечение кабеля
	 * 	@param string $material - материал кабеля
	 * 	
	 * 	@return array - массив сопротивлений ['R' => ..., 'X' => ...]
	 */
	public static function getResistance(float $sLine, string $material = 'Cu'):array {
		$str = 'R_'.$material;
		$R = self::RESISTANCE["$sLine"]["$str"];
		$X = self::RESISTANCE["$sLine"]['X'];
		return ['X' => $X, 'R' => $R];
	}
}