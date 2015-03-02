<?php

namespace D4w\Ect\Cep;

/**
 * @see http://blog.thiagorodrigo.com.br/index.php/cep-brasil-relacao-estados-capitais-interior-regiao-metropolitana?blog=5
 */
class Faixas
{
	protected static $ceps = array(
		'sp' => array('01000','19999'),
		'rj' => array('20000','28999'),
		'es' => array('29000','29999'),
		'mg' => array('30000','39999'),
		'ba' => array('40000','48999'),
		'se' => array('49000','49999'),
		'pe' => array('50000','56999'),
		'al' => array('57000','57999'),
		'pb' => array('58000','58999'),
		'rn' => array('59000','59999'),
		'ce' => array('60000','63999'),
		'pi' => array('64000','64999'),
		'ma' => array('65000','65999'),
		'pa' => array('66000','68899'),
		'ap' => array('68900','68999'),
		'am-1' => array('69000','69299'),
		'am-2' => array('69400','69899'),
		'rr' => array('69300','69399'),
		'ac' => array('69900','69999'),
		'df-1' => array('70000','72799'),
		'df-2' => array('73000','73699'),
		'go-1' => array('72800','72999'),
		'go-2' => array('73700','76799'),
		'to' => array('77000','77999'),
		'mt' => array('78000','78899'),
		'ro' => array('78900','78999'),
		'ms' => array('79000','79999'),
		'pr' => array('80000','87999'),
		'sc' => array('88000','89999'),
		'rs' => array('90000','99999'),
	);

	/**
	 * Retorna o estado de um cep
	 * @param  string $cep CEP
	 * @return array Retorna array onde index 0 é o estado e caso seja de Brasília index 1 é igual a 'df'
	 */
	public static function getEstado($cep)
	{
		$cep = preg_replace('/[^0-9]/', '', $cep);
		$prefixo = substr($cep, 0, 5);
		$prefixo_int = intval($prefixo);

		foreach (self::$ceps as $estado => $espectro) {
			$ini = intval($espectro[0]);
			$fim = intval($espectro[1]);
			if ($prefixo_int >= $ini && $prefixo_int <= $fim) {
				return substr($estado, 0, 2);
			}
		}

		return false;
	}
}