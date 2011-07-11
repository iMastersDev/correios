<?php
/**
 * @brief	Protocolo HTTP
 * @details	Classes e interfaces relacionadas com o protocolo HTTP
 * @package com.imasters.php.http
 */

require_once 'com/imasters/php/http/Cookie.php';

/**
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 * @brief	Interface para definição de um gerenciador de cookies.
 */
interface CookieManager extends Serializable {
	/**
	 * @brief	Adiciona um cookie para ser armazenado pelo gerenciador.
	 * @param	Cookie $cookie
	 */
	public function addCookie( Cookie $cookie );

	/**
	 * @brief	Recupera os cookies armazenados para um determinado
	 * domínio.
	 * @param	string $domain Domínio dos cookies.
	 * @param	boolean $secure Indica ambiente seguro (https).
	 * @param	string $path Caminho dos cookies.
	 * @return	string O valor retornado segue o padrão especificado
	 * pela RFC 2965 para ser utilizado diretamente no campo de
	 * cabeçalho Cookie.
	 */
	public function getCookie( $domain , $secure , $path );

	/**
	 * @brief	Recupera uma lista com os cookies gerenciados.
	 * @param	string $domain Domínio dos cookies.
	 * @param	boolean $secure Indica ambiente seguro.
	 * @param	string $path Caminho dos cookies.
	 * @return	Iterator
	 */
	public function getCookieIterator( $domain , $secure , $path );

	/**
	 * @brief	Define o conteúdo do campo de cabeçalho Set-Cookie
	 * retornado pelo servidor.
	 * @param	string $setCookie
	 * @param	string $domain
	 */
	public function setCookie( $setCookie , $domain = null );
}