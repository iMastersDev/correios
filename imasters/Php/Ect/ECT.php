<?php
/**
 * @brief	Biblioteca Correios
 * @details	Classes e interfaces para integração com a API do Correios
 * @package com.imasters.php.ect
 */

namespace Imasters\Php\Ect;

use \Imasters\Php\Http\HTTPConnection;
use \Imasters\Php\Http\HTTPCookieManager;

use \Imasters\Php\Ect\Prdt\Prdt;

/**
 * @brief	Interface para APIs dos Correios (ECT)
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 */
class ECT {
	/**
	 * @var	HTTPConnection
	 */
	private $httpConnection;

	/**
	 * @brief	Conexão HTTP
	 * @details	Recupera um objeto de conexão HTTP para ser utilizado
	 * nas chamadas às operações da API.
	 * @return	HTTPConnection
	 */
	public function getHTTPConnection() {
		$httpConnection = new HTTPConnection();
		$httpConnection->setCookieManager( new HTTPCookieManager() );

		return $httpConnection;
	}

	/**
	 * @brief	Objeto de integração para consultas de preços e prazos
	 * @return	Prdt
	 */
	public function prdt() {
		return new Prdt( $this );
	}
}