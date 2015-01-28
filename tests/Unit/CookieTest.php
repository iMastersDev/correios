<?php

require_once __DIR__.'/../../vendor/autoload.php';

class CookieTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testConstructor()
	{
		$ck = new \Imasters\Php\Http\Cookie('test', '123', 'localhost', '!ISSO DEVERIA SER NUMÉRICO!');
	}
}