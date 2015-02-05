<?php
/**
 * @brief	Protocolo HTTP
 * @details	Classes e interfaces relacionadas com o protocolo HTTP
 * @package com.imasters.php.http
 */

namespace Imasters\Php\Http;

/**
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 * @brief	Resposta HTTP
 * @details	Implementação de um objeto representa uma resposta HTTP.
 */
class HTTPResponse {
	/**
	 * @var	array
	 */
	private $responseHeader = array();

	/**
	 * @var	string
	 */
	private $responseBody;

	/**
	 * @var	integer
	 */
	private $statusCode;

	/**
	 * @var	string
	 */
	private $statusMessage;

	/**
	 * @brief	Recupera o corpo da resposta HTTP.
	 * @return	string
	 */
	public function getContent() {
		return $this->responseBody;
	}

	/**
	 * @brief	Recupera o tamanho do corpo da resposta.
	 * @return	integer
	 */
	public function getContentLength() {
		return $this->getHeaderInt( 'Content-Length' );
	}

	/**
	 * @brief	Recupera o tipo de conteúdo da resposta.
	 * @return	string
	 */
	public function getContentType() {
		return $this->getHeader( 'Content-Type' );
	}

	/**
	 * @brief	Recupera o código de status da resposta do servidor.
	 * @return	integer
	 */
	public function getStatusCode() {
		return $this->statusCode;
	}

	/**
	 * @brief	Recupera a mensagem de status da resposta do servidor.
	 * @return	string
	 */
	public function getStatusMessage() {
		return $this->statusMessage;
	}

	/**
	 * @brief	Verifica se existe um cabeçalho de resposta HTTP.
	 * @param	string $name Nome do cabeçalho
	 * @return	boolean
	 */
	public function hasResponseHeader( $name ) {
		return isset( $this->responseHeader[ strtolower( $name ) ] );
	}

	/**
	 * @brief	Recupera o valor um campo de cabeçalho da resposta HTTP.
	 * @param	string $name Nome do campo de cabeçalho.
	 * @return	string O valor do campo ou NULL se não estiver
	 * existir.
	 */
	public function getHeader( $name ) {
		$key = strtolower( $name );

		if ( isset( $this->responseHeader[ $key ] ) ) {
			if ( !isset( $this->responseHeader[ $key ][ 'name' ] ) && is_array( $this->responseHeader[ $key ] ) ) {
				$values = array();

				foreach ( $this->responseHeader[ $key ] as $header ) {
					$values[] = $header[ 'value' ];
				}

				return $values;
			} else {
				return $this->responseHeader[ $key ][ 'value' ];
			}
		}

		return null;
	}

	/**
	 * @brief	Recupera um valor como inteiro de um campo de cabeçalho da
	 * resposta HTTP.
	 * @param	string $name Nome do campo de cabeçalho.
	 * @return	integer
	 */
	public function getHeaderInt( $name ) {
		return (int) $this->getHeader( $name );
	}

	/**
	 * @brief	Recupera um valor como unix timestamp de um campo de cabeçalho
	 * da resposta HTTO.
	 * @param	string $name Nome do campo de cabeçalho.
	 * @return	integer UNIX Timestamp ou NULL se não estiver definido.
	 */
	public function getHeaderDate( $name ) {
		$date = $this->getHeader( $name );

		if ( !is_null( $date ) && !empty( $date ) ) {
			return strtotime( $date );
		}
	}

	/**
	 * @brief	Define a resposta da requisição HTTP.
	 * @param	string $response Toda a resposta da requisição
	 */
	public function setRawResponse( $response , CookieManager $cookieManager = null ) {
		$parts = explode( "\r\n\r\n" , $response );

		if ( count( $parts ) == 2 ) {
			$matches = array();
			$this->responseBody = $parts[ 1 ];

			if ( preg_match_all( "/(HTTP\\/[1-9]\\.[0-9]\\s+(?<statusCode>\\d+)\\s+(?<statusMessage>.*)|(?<headerName>[^:]+)\\s*:\\s*(?<headerValue>.*))\r\n/m" , $parts[ 0 ] , $matches ) ) {
				foreach ( $matches[ 'statusCode' ] as $offset => $match ) {
					if ( !empty( $match ) ) {
						$this->statusCode = (int) $match;
						$this->statusMessage = $matches[ 'statusMessage' ][ $offset ];
						break;
					}
				}

				foreach ( $matches[ 'headerName' ] as $offset => $name ) {
					if ( !empty( $name ) ) {
						$key = strtolower( $name );
						$header = array(
							'name'	=> $name,
							'value'	=> $matches[ 'headerValue' ][ $offset ]
						);

						if ( isset( $this->responseHeader[ $key ] ) ) {
							if ( isset( $this->responseHeader[ $key ][ 'name' ] ) ) {
								$this->responseHeader[ $key ] = array( $this->responseHeader[ $key ] );
							}

							$this->responseHeader[ $key ][] = $header;

						} else {
							$this->responseHeader[ $key ] = $header;
						}
					}
				}
			}
		} else {
			$this->responseBody = $response;
		}
	}
}