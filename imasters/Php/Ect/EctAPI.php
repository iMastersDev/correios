<?php
/**
 * @brief	Biblioteca Correios
 * @details	Classes e interfaces para integração com a API do Correios
 * @package com.imasters.php.ect
 */

namespace Imasters\Php\Ect;

/**
 * @brief	Interface para definição de uma API do Correios
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 */
abstract class EctAPI {
	/**
	 * @var	ECT
	 */
	protected $ect;

	/**
	 * @var	HTTPConnection
	 */
	protected $httpConnection;

	/**
	 * @brief	Constroi o objeto que representa uma API do Correios
	 * @param	ECT $ect
	 */
	public function __construct( ECT $ect ) {
		$this->ect = $ect;
		$this->httpConnection = $ect->getHTTPConnection();
		$this->httpConnection->initialize( $this->getTargetHost() );
	}

	/**
	 * @brief	Recupera o host onde serão feitas as requisições
	 * @return	string
	 */
	public abstract function getTargetHost();
}