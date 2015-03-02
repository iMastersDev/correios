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

	protected static $ceps_capitais = array(
 		'ac' => array('capital' => 'Rio Branco', 'cep_ini' => '69900', 'cep_fim' => '69920'),
 		'al' => array('capital' => 'Maceió', 'cep_ini' => '57000', 'cep_fim' => '57099'),
 		'am' => array('capital' => 'Manaus', 'cep_ini' => '69000', 'cep_fim' => '69099'),
 		'ap' => array('capital' => 'Macapá', 'cep_ini' => '68900', 'cep_fim' => '68914'),
 		'ba' => array('capital' => 'Salvador', 'cep_ini' => '40000', 'cep_fim' => '41999'),
 		'ce' => array('capital' => 'Fortaleza', 'cep_ini' => '60000', 'cep_fim' => '60999'),
 		'df' => array('capital' => 'Brasília', 'cep_ini' => '70700', 'cep_fim' => '70999'),
 		'es' => array('capital' => 'Vitória', 'cep_ini' => '29000', 'cep_fim' => '29099'),
 		'go' => array('capital' => 'Goiânia', 'cep_ini' => '74000', 'cep_fim' => '74894'),
 		'ma' => array('capital' => 'São Luís', 'cep_ini' => '65000', 'cep_fim' => '65099'),
 		'mg' => array('capital' => 'Belo Horizonte', 'cep_ini' => '30000', 'cep_fim' => '31999'),
 		'ms' => array('capital' => 'Campo Grande', 'cep_ini' => '79000', 'cep_fim' => '79129'),
 		'mt' => array('capital' => 'Cuiabá', 'cep_ini' => '78000', 'cep_fim' => '78109'),
 		'pa' => array('capital' => 'Belém', 'cep_ini' => '66000', 'cep_fim' => '66999'),
 		'pb' => array('capital' => 'João Pessoa', 'cep_ini' => '58000', 'cep_fim' => '58099'),
 		'pe' => array('capital' => 'Recife', 'cep_ini' => '50000', 'cep_fim' => '52999'),
 		'pi' => array('capital' => 'Teresina', 'cep_ini' => '64000', 'cep_fim' => '64099'),
 		'pr' => array('capital' => 'Curitiba', 'cep_ini' => '80000', 'cep_fim' => '82999'),
 		'rj' => array('capital' => 'Rio de Janeiro', 'cep_ini' => '20000', 'cep_fim' => '23799'),
 		'rn' => array('capital' => 'Natal', 'cep_ini' => '59000', 'cep_fim' => '59099'),
 		'ro' => array('capital' => 'Porto Velho', 'cep_ini' => '78900', 'cep_fim' => '78930'),
 		'rr' => array('capital' => 'Boa Vista', 'cep_ini' => '69300', 'cep_fim' => '69339'),
 		'rs' => array('capital' => 'Porto Alegre', 'cep_ini' => '90000', 'cep_fim' => '91999'),
 		'sc' => array('capital' => 'Florianópolis', 'cep_ini' => '88000', 'cep_fim' => '82999'),
 		'se' => array('capital' => 'Aracaju', 'cep_ini' => '49000', 'cep_fim' => '49099'),
 		'sp' => array('capital' => 'São Paulo', 'cep_ini' => '01000', 'cep_fim' => '05999'),
 		'to' => array('capital' => 'Palmas', 'cep_ini' => '77000', 'cep_fim' => '77270'),	
	);

	/**
	 * Retorna o estado de um cep
	 * @param  string $cep CEP
	 * @return array Retorna array onde index 0 é o estado e caso seja de Brasília index 1 é igual a 'df'
	 */
	public static function getEstado($cep)
	{
		$prefixo_int = self::prefixo($cep);

		foreach (self::$ceps as $estado => $espectro) {
			$ini = intval($espectro[0]);
			$fim = intval($espectro[1]);
			if ($prefixo_int >= $ini && $prefixo_int <= $fim) {
				return substr($estado, 0, 2);
			}
		}

		return false;
	}

	public static function isCapital($cep)
	{
		$prefixo = self::prefixo($cep);
		foreach (self::$ceps_capitais as $estado => $val) {
			$ini = intval($val['cep_ini']);
			$fim = intval($val['cep_fim']);
			if ($prefixo >= $ini && $prefixo <= $fim) {
				return true;
			}
		}
		return false;
	}

	protected static function prefixo($cep)
	{
		$cep = preg_replace('/[^0-9]/', '', $cep);
		$prefixo = substr($cep, 0, 5);
		return intval($prefixo);
	}
}