<?php
/**
 * @brief	Protocolo HTTP
 * @details	Classes e interfaces relacionadas com o protocolo HTTP
 * @package com.imasters.php.http
 */

require_once 'com/imasters/php/http/HTTPConnection.php';
require_once 'com/imasters/php/http/HTTPAuthenticator.php';
require_once 'com/imasters/php/http/HTTPRequestMethod.php';

/**
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 * @brief	Requisição HTTP
 * @details	Interface para definição de um objeto que fará uma
 * requisição HTTP.
 */
interface HTTPRequest {
	/**
	 * @brief	Adiciona um campo de cabeçalho para ser enviado com a
	 * requisição.
	 * @param	string $name Nome do campo de cabeçalho.
	 * @param	string $value Valor do campo de cabeçalho.
	 * @param	boolean $override Indica se o campo deverá
	 * ser sobrescrito caso já tenha sido definido.
	 * @throws	InvalidArgumentException Se o nome ou o valor
	 * do campo não forem valores scalar.
	 */
	public function addRequestHeader( $name , $value , $override = true );

	/**
	 * @brief	Autentica uma requisição HTTP.
	 * @param	HTTPAuthenticator $authenticator
	 */
	public function authenticate( HTTPAuthenticator $authenticator );

	/**
	 * @brief	Fecha a requisição.
	 */
	public function close();

	/**
	 * @brief	Executa a requisição HTTP
	 * @details	Executa a requisição HTTP em um caminho utilizando um
	 * método específico.
	 * @param	string $method Método da requisição.
	 * @param	string $path Alvo da requisição.
	 * @return	string Resposta HTTP.
	 * @throws	BadMethodCallException Se não houver uma conexão
	 * inicializada.
	 */
	public function execute( $path = '/' , $method = HTTPRequestMethod::GET );

	/**
	 * @brief	Recupera a resposta da requisição.
	 * @return	HTTPResponse
	 */
	public function getResponse();

	/**
	 * @brief	Abre a requisição.
	 * @param	HTTPConnection $httpConnection Conexão HTTP
	 * relacionada com essa requisição
	 */
	public function open( HTTPConnection $httpConnection );

	/**
	 * @brief	Define um parâmetro
	 * @details	Define um parâmetro que será enviado com a requisição,
	 * um parâmetro é um par nome-valor que será enviado como uma
	 * query string (<b>ex:</b> <i>?name=value</i>).
	 * @param	string $name Nome do parâmetro.
	 * @param	string $value Valor do parâmetro.
	 * @throws	InvalidArgumentException Se o nome ou o valor
	 * do campo não forem valores scalar.
	 */
	public function setParameter( $name , $value );

	/**
	 * @brief	Corpo da requisição HTTP.
	 * @param	string $contentBody
	 */
	public function setRequestBody( $requestBody );
}