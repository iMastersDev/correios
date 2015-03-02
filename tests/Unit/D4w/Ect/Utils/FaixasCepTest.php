<?php

require_once __DIR__.'/../../../../../vendor/autoload.php';

class FaixasTest extends PHPUnit_Framework_TestCase
{

	public function testPrefixo()
	{
		$cep = '01000-800';
		$cep = preg_replace('/[^0-9]/', '', $cep);
		$this->assertEquals('01000800', $cep);

		$prefixo = substr($cep, 0, 5);
		$this->assertEquals('01000', $prefixo);
		
		$prefixo_int = intval($prefixo);
		$this->assertEquals(1000, $prefixo_int);
	}

	public function testEstado()
	{
		// goias e distrito federal tem teste a parte
		// 
		$this->assertEquals('ac', \D4w\Ect\Cep\Faixas::getEstado('69900-010'));
		$this->assertEquals('al', \D4w\Ect\Cep\Faixas::getEstado('57010-060'));
		$this->assertEquals('am', \D4w\Ect\Cep\Faixas::getEstado('69005-050'));
		$this->assertEquals('ap', \D4w\Ect\Cep\Faixas::getEstado('68900-021'));
		$this->assertEquals('ba', \D4w\Ect\Cep\Faixas::getEstado('40015-060'));
		$this->assertEquals('ce', \D4w\Ect\Cep\Faixas::getEstado('60010-122'));
		$this->assertEquals('es', \D4w\Ect\Cep\Faixas::getEstado('29010-060'));
		$this->assertEquals('ma', \D4w\Ect\Cep\Faixas::getEstado('65010-230'));
		$this->assertEquals('mg', \D4w\Ect\Cep\Faixas::getEstado('31814-320'));
		$this->assertEquals('ms', \D4w\Ect\Cep\Faixas::getEstado('79002-042'));
		$this->assertEquals('mt', \D4w\Ect\Cep\Faixas::getEstado('78005-060'));
		$this->assertEquals('pa', \D4w\Ect\Cep\Faixas::getEstado('67033-027'));
		$this->assertEquals('pb', \D4w\Ect\Cep\Faixas::getEstado('58109-115'));
		$this->assertEquals('pe', \D4w\Ect\Cep\Faixas::getEstado('53550-340'));
		$this->assertEquals('pi', \D4w\Ect\Cep\Faixas::getEstado('64200-510'));
		$this->assertEquals('pr', \D4w\Ect\Cep\Faixas::getEstado('83512-205'));
		$this->assertEquals('rj', \D4w\Ect\Cep\Faixas::getEstado('23953-440'));
		$this->assertEquals('rn', \D4w\Ect\Cep\Faixas::getEstado('59621-483'));
		$this->assertEquals('ro', \D4w\Ect\Cep\Faixas::getEstado('78903-410'));
		$this->assertEquals('rr', \D4w\Ect\Cep\Faixas::getEstado('69312-205'));
		$this->assertEquals('rs', \D4w\Ect\Cep\Faixas::getEstado('96065-772'));
		$this->assertEquals('sc', \D4w\Ect\Cep\Faixas::getEstado('89280-174'));
		$this->assertEquals('se', \D4w\Ect\Cep\Faixas::getEstado('49087-446'));
		$this->assertEquals('sp', \D4w\Ect\Cep\Faixas::getEstado('13475-214'));
		$this->assertEquals('to', \D4w\Ect\Cep\Faixas::getEstado('77063-430'));
	}

	public function testBrasilia()
	{
		$this->assertEquals('df', \D4w\Ect\Cep\Faixas::getEstado('72300-530'));
		$this->assertEquals('df', \D4w\Ect\Cep\Faixas::getEstado('70278-070'));
		$this->assertEquals('df', \D4w\Ect\Cep\Faixas::getEstado('71745-606'));
		$this->assertEquals('df', \D4w\Ect\Cep\Faixas::getEstado('72331-006'));
	}

	// teste de faixas para cep Goias e DF está com problema
	public function testGoias()
	{
		$this->assertEquals('go', \D4w\Ect\Cep\Faixas::getEstado('72912-445'));
		$this->assertEquals('go', \D4w\Ect\Cep\Faixas::getEstado('72800-160'));
		$this->assertEquals('go', \D4w\Ect\Cep\Faixas::getEstado('72800-160'));
	}

}