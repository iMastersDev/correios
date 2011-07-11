<?php
/**
 * @brief	Protocolo HTTP
 * @details	Classes e interfaces relacionadas com o protocolo HTTP
 * @package com.imasters.php.http
 */

require_once 'com/imasters/php/http/HTTPRequest.php';
require_once 'com/imasters/php/http/HTTPResponse.php';

/**
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 * @brief	Requisição HTTP cURL
 * @details	Implementação da interface HTTPRequest para uma
 * requisição HTTP que utiliza cURL.
 */
class CURL implements HTTPRequest {
	/**
	 * @var	resource
	 */
	private $curlResource;

	/**
	 * @var	HTTPConnection
	 */
	private $httpConnection;

	/**
	 * @var	HTTPResponse
	 */
	private $httpResponse;

	/**
	 * @var	boolean
	 */
	private $openned = false;

	/**
	 * @var	string
	 */
	private $requestBody;

	/**
	 * @var	array
	 */
	private $requestHeader = array();

	/**
	 * @var	array
	 */
	private $requestParameter = array();

	/**
	 * @brief	Destroi o objeto
	 * @details	Destroi o objeto e fecha a requisição se estiver
	 * aberta.
	 */
	public function __destruct() {
		$this->close();
	}

	/**
	 * @see HTTPRequest::addRequestHeader()
	 */
	public function addRequestHeader( $name , $value , $override = true ) {
		if ( is_scalar( $name ) && is_scalar( $value ) ) {
			$key = strtolower( $name );

			if ( $override === true || !isset( $this->requestHeader[ $key ] ) ) {
				$this->requestHeader[ $key ] = array( 'name' => $name , 'value' => $value );

				return true;
			}

			return false;
		} else {
			throw new InvalidArgumentException( '$name e $value precisam ser strings.' );
		}
	}

	/**
	 * @brief	Autentica uma requisição HTTP.
	 * @param	HTTPAuthenticator $authenticator
	 * @see		HTTPRequest::authenticate()
	 */
	public function authenticate( HTTPAuthenticator $authenticator ) {
		$authenticator->authenticate( $this );
	}

	/**
	 * @see HTTPRequest::close()
	 */
	public function close() {
		if ( $this->openned ) {
			curl_close( $this->curlResource );
			$this->openned = false;
		}
	}

	/**
	 * @see HTTPRequest::execute()
	 */
	public function execute( $path = '/' , $method = HTTPRequestMethod::GET ) {
		$targetURL = $this->httpConnection->getURI() . $path;
		$hasParameters = count( $this->requestParameter ) > 0;
		$query = $hasParameters ? http_build_query( $this->requestParameter ) : null;

		switch ( $method ) {
			case HTTPRequestMethod::PUT :
			case HTTPRequestMethod::POST :
				if ( $method != HTTPRequestMethod::POST ) {
					curl_setopt( $this->curlResource , CURLOPT_CUSTOMREQUEST , $method );
				} else {
					curl_setopt( $this->curlResource , CURLOPT_POST , 1 );
				}

				if ( empty( $this->requestBody ) ) {
					curl_setopt( $this->curlResource , CURLOPT_POSTFIELDS , $query );
				} else {
					if ( $hasParameters ) {
						$targetURL .= '?' . $query;
					}

					curl_setopt( $this->curlResource , CURLOPT_POSTFIELDS , $this->requestBody );
				}

				curl_setopt( $this->curlResource , CURLOPT_URL , $targetURL );

				break;
			case HTTPRequestMethod::DELETE :
			case HTTPRequestMethod::HEAD :
			case HTTPRequestMethod::OPTIONS:
			case HTTPRequestMethod::TRACE:
				curl_setopt( $this->curlResource , CURLOPT_CUSTOMREQUEST , $method );
			case HTTPRequestMethod::GET:
				if ( $hasParameters ) {
					$targetURL .= '?' . $query;
				}

				curl_setopt( $this->curlResource , CURLOPT_URL , $targetURL );

				break;
			default :
				throw new UnexpectedValueException( 'Método desconhecido' );
		}

		$resp = curl_exec( $this->curlResource );
		$errno = curl_errno( $this->curlResource );
		$error = curl_error( $this->curlResource );

		if ( $errno != 0 ) {
			throw new RuntimeException( $error , $errno );
		}

		$this->httpResponse = new HTTPResponse();
		$this->httpResponse->setRawResponse( $resp );

		if ( $this->httpResponse->hasResponseHeader( 'Set-Cookie' ) ) {
			$cookieManager = $this->httpConnection->getCookieManager();

			if ( $cookieManager != null ) {
				$cookieManager->setCookie( $this->httpResponse->getHeader( 'Set-Cookie' ) , $this->httpConnection->getHostName() );
			}
		}

		$statusCode = $this->httpResponse->getStatusCode();

		return $statusCode < 400;
	}

	/**
	 * @see HTTPRequest::getResponse()
	 */
	public function getResponse() {
		return $this->httpResponse;
	}

	/**
	 * @see HTTPRequest::open()
	 */
	public function open( HTTPConnection $httpConnection ) {
		if ( function_exists( 'curl_init' ) ) {
			/**
			 * Fechamos uma conexão existente antes de abrir uma nova
			 */
			$this->close();

			$curl = curl_init();

			/**
			 * Verificamos se o recurso CURL foi criado com êxito
			 */
			if ( is_resource( $curl ) ) {
				curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , 0 );
				curl_setopt( $curl , CURLOPT_HEADER , 1 );
				curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
				curl_setopt( $curl , CURLINFO_HEADER_OUT , 1 );

				if ( ( $timeout = $httpConnection->getTimeout() ) != null ) {
					curl_setopt( $curl , CURLOPT_TIMEOUT , $timeout );
				}

				if ( ( $connectionTimeout = $httpConnection->getConnectionTimeout() ) != null ) {
					curl_setopt( $curl , CURLOPT_CONNECTTIMEOUT , $connectionTimeout );
				}

				$headers = array();

				foreach ( $this->requestHeader as $header ) {
					$headers[] = sprintf( '%s: %s' , $header[ 'name' ] , $header[ 'value' ] );
				}

				curl_setopt( $curl , CURLOPT_HTTPHEADER , $headers );

				$this->curlResource = $curl;
				$this->httpConnection = $httpConnection;
				$this->openned = true;
			} else {
				throw new RuntimeException( 'Não foi possível iniciar cURL' );
			}
		} else {
			throw new RuntimeException( 'Extensão cURL não está instalada.' );
		}
	}

	/**
	 * @brief	Define um parâmetro
	 * @details	Define um parâmetro que será enviado com a requisição,
	 * um parâmetro é um par nome-valor que será enviado como uma
	 * query string (<b>ex:</b> <i>?name=value</i>).
	 * @param	string $name Nome do parâmetro.
	 * @param	string $value Valor do parâmetro.
	 * @throws	InvalidArgumentException Se o nome ou o valor
	 * do campo não forem valores scalar.
	 * @see		HTTPRequest::setParameter()
	 */
	public function setParameter( $name , $value ) {
		$this->requestParameter[ $name ] = $value;
	}

	/**
	 * @see HTTPRequest::setRequestBody()
	 */
	public function setRequestBody( $requestBody ) {
		$this->requestBody = $requestBody;
	}
}