<?php
/**
 * @brief	Protocolo HTTP
 * @details	Classes e interfaces relacionadas com o protocolo HTTP
 * @package com.imasters.php.http
 */

/**
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 * @brief	Cookie HTTP
 * @details	Implementação de um cookie HTTP segundo a especificação
 * RFC 2109.
 */
class Cookie {
	/**
	 * @brief	Comentário opcional do cookie
	 * @var		string
	 */
	protected $comment;

	/**
	 * @brief	Domínio do cookie
	 * @var		string
	 */
	protected $domain;

	/**
	 * @brief	Expiração do cookie (unix timestamp)
	 * @var		integer
	 */
	protected $expires;

	/**
	 * @brief	Nome do cookie
	 * @var		string
	 */
	protected $name;

	/**
	 * @brief	Caminho do cookie
	 * @var		string
	 */
	protected $path;

	/**
	 * @brief	Ambiente seguro (HTTPS)
	 * @details	Indica se o User-Agent deve utilizar o cookie
	 * apenas em ambiente seguro (HTTPS)
	 * @var		boolean
	 */
	protected $secure;

	/**
	 * @brief	Valor do cookie
	 * @var		string
	 */
	protected $value;

	/**
	 * @brief	Constroi um cookie
	 * @param	string $name Nome do cookie
	 * @param	string $value Valor do cookie
	 * @param	string $domain Domínio do cookie
	 * @param	integer $expires Timestamp da expiração do cookie
	 * @param	string $path Caminho do cookie
	 * @param	boolean $secure Se o cookie é usado apenas em ambiente
	 * seguro.
	 * @param	string $comment Comentário do cookie
	 * @throws	InvalidArgumentException Se $expires não for um número
	 */
	public function __construct( $name , $value , $domain , $expires , $path = '/' , $secure = false , $comment = null ) {
		$this->name = (string) $name;
		$this->value = (string) $value;
		$this->domain = (string) $domain;

		if ( is_numeric( $expires ) ) {
			$this->expires = (int) $expires;
		} else {
			throw new InvalidArgumentException( '$expires deve ser um número representando o timestamp da expiração do cookie, "' . $expires . '" foi dado.' );
		}

		$this->path = (string) $path;
		$this->secure = $secure === true;
		$this->comment = $comment;
	}

	/**
	 * @brief	Retorna a representação do Cookie como uma string
	 * @return	string
	 */
	public function __toString() {
		return sprintf( '%s=%s' , $this->name , $this->value );
	}

	/**
	 * @brief	Recupera o comentário do cookie
	 * @return	string
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @brief	Recupera o domínio do cookie
	 * @return	string
	 */
	public function getDomain() {
		return $this->domain;
	}

	/**
	 * @brief	Recupera o timestamp da expiração do cookie
	 * @return	integer
	 */
	public function getExpires() {
		return $this->expires;
	}

	/**
	 * @brief	Recupera o nome do cookie
	 * @return	string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @brief	Recupera o caminho do cookie
	 * @return	string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * @brief	Recupera o valor do cookie
	 * @return	string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @brief	Verifica ambiente seguro.
	 * @details	Verifica se o User-Agent deve utilizar o
	 * cookie apenas em ambiente seguro.
	 * @return	boolean
	 */
	public function isSecure() {
		return $this->secure;
	}
}