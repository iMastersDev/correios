<?php

require_once __DIR__.'/../../vendor/autoload.php';

class CorreiosTest extends PHPUnit_Framework_TestCase
{
	public function testInstances()
	{
		$ect = new \Imasters\Php\Ect\ECT();
		$this->assertInstanceOf('\Imasters\Php\Ect\ECT', $ect);

		$prdt = $ect->prdt();
		$this->assertInstanceOf('\Imasters\Php\Ect\Prdt\Prdt', $prdt);
	}
}