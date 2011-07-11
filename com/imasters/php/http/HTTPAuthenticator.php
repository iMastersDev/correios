<?php
/**
 * @brief	Protocolo HTTP
 * @details	Classes e interfaces relacionadas com o protocolo HTTP
 * @package com.imasters.php.http
 */

require_once 'com/imasters/php/http/HTTPRequest.php';

/**
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 * @brief	Interface para definição de um autenticador HTTP.
 */
interface HTTPAuthenticator {
	/**
	 * @brief	Autentica uma requisição HTTP.
	 * @param	HTTPRequest $httpRequest
	 */
	public function authenticate( HTTPRequest $httpRequest );
}