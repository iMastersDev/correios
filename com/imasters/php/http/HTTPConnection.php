<?php
/**
 * @brief	Protocolo HTTP
 * @details	Classes e interfaces relacionadas com o protocolo HTTP
 * @package com.imasters.php.http
 */

require_once 'com/imasters/php/http/HTTPAuthenticator.php';
require_once 'com/imasters/php/http/HTTPRequestMethod.php';
require_once 'com/imasters/php/http/CURL.php';

/**
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 * @brief	Implementação de um conector HTTP.
 */
class HTTPConnection {
	/**
	 * @brief	Porta padrão de uma conexão HTTP não segura.
	 */
	const HTTP_PORT = 80;

	/**
	 * @brief	Porta padrão de uma conexão HTTP segura.
	 */
	const HTTPS_PORT = 443;

	/**
	 * @var	HTTPAuthenticator
	 */
	protected $httpAuthenticator;

	/**
	 * @var	CookieManager
	 */
	protected $cookieManager;

	/**
	 * @var	integer
	 */
	protected $connectionTimeout;

	/**
	 * @var	string
	 */
	protected $hostname;

	/**
	 * @var	boolean
	 */
	protected $initialized = false;

	/**
	 * @var	integer
	 */
	protected $port;

	/**
	 * @var	string
	 */
	protected $requestBody;

	/**
	 * @var	array
	 */
	protected $requestHeader;

	/**
	 * @var	array
	 */
	protected $requestParameter;

	/**
	 * @var	boolean
	 */
	protected $secure;

	/**
	 * @var	integer
	 */
	protected $timeout;

	/**
	 * @var	string
	 */
	protected static $userAgent;

	/**
	 * @brief	Constroi o objeto de conexão HTTP.
	 */
	public function __construct() {
		if ( self::$userAgent == null ) {
			$locale = setlocale( LC_ALL , null );

			if ( function_exists( 'posix_uname' ) ) {
				$uname = posix_uname();

				self::$userAgent = sprintf( 'Mozilla/4.0 (compatible; %s; PHP/%s; %s %s; %s)' , PHP_SAPI , PHP_VERSION , $uname[ 'sysname' ] , $uname[ 'machine' ] , $locale );
			} else {
				self::$userAgent = sprintf( 'Mozilla/4.0 (compatible; %s; PHP/%s; %s; %s)' , PHP_SAPI , PHP_VERSION , PHP_OS , $locale );
			}
		}

		$this->requestHeader = array();
		$this->requestParameter = array();
	}

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
	public function addHeader( $name , $value , $override = true ) {
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
	 * @brief	Fecha a conexão.
	 * @throws	BadMethodCallException Se não houver uma conexão
	 * inicializada.
	 */
	public function close() {
		$this->initialized = false;
	}

	/**
	 * @brief	Executa a requisição
	 * @details	Executa a requisição HTTP em um caminho utilizando um
	 * método específico.
	 * @param	string $path Caminho da requisição.
	 * @param	string $method Método da requisição.
	 * @return	HTTPResponse Resposta HTTP.
	 * @throws	BadMethodCallException Se não houver uma conexão
	 * inicializada ou se o objeto de requisição não for válido.
	 */
	public function execute( $path = '/' , $method = HTTPRequestMethod::GET ) {
		$request = $this->newRequest();

		if ( $request instanceof HTTPRequest ) {
			$host = $this->getHost();
			$accept = '*/*';
			$userAgent = self::$userAgent;

			if ( isset( $this->requestHeader[ 'Host' ] ) ) {
				$host = $this->requestHeader[ 'host' ][ 'value' ];

				unset( $this->requestHeader[ 'host' ] );
			}

			if ( isset( $this->requestHeader[ 'accept' ] ) ) {
				$accept = $this->requestHeader[ 'accept' ][ 'value' ];

				unset( $this->requestHeader[ 'accept' ] );
			}

			if ( isset( $this->requestHeader[ 'user-agent' ] ) ) {
				$userAgent = $this->requestHeader[ 'user-agent' ][ 'value' ];

				unset( $this->requestHeader[ 'user-agent' ] );
			}

			$request->addRequestHeader( 'Host' , $host );
			$request->addRequestHeader( 'Accept' , $accept );
			$request->addRequestHeader( 'User-Agent' , $userAgent );

			if ( $this->httpAuthenticator != null ) {
				$request->authenticate( $this->httpAuthenticator );
			}

			foreach ( $this->requestHeader as $header ) {
				$request->addRequestHeader( $header[ 'name' ] , $header[ 'value' ] );
			}

			$cookieManager = $this->getCookieManager();

			if ( $cookieManager != null ) {
				$cookies = $cookieManager->getCookie( $this->getHostName() , $this->isSecure() , $path );

				if ( isset( $this->requestHeader[ 'cookie' ] ) ) {
					$buffer = $this->requestHeader[ 'cookie' ][ 'value' ] . '; ' . $cookies;
				} else {
					$buffer = $cookies;
				}

				$request->addRequestHeader( 'Cookie' , $buffer );
			}

			foreach ( $this->requestParameter as $name => $value ) {
				$request->setParameter( $name , $value );
			}

			$request->setRequestBody( $this->requestBody );

			if ( $path == null || !is_string( $path ) || empty( $path ) ) {
				$path = '/';
			} else if ( substr( $path , 0 , 1 ) != '/' ) {
				$path = '/' . $path;
			}

			if ( $this->timeout != null ) {
				$request->setTimeout( $this->timeout );
			}

			if ( $this->connectionTimeout != null ) {
				$request->setConnectionTimeout( $this->connectionTimeout );
			}

			$request->open( $this );
			$request->execute( $path , $method );

			return $request->getResponse();
		} else {
			throw new BadMethodCallException( 'Objeto de requisição inválido.' );
		}
	}

	/**
	 * @brief	Recupera o timeout de conexão.
	 * @return	integer
	 */
	public function getConnectionTimeout() {
		return $this->connectionTimeout;
	}

	/**
	 * @brief	Recupera o gerenciador de Cookies.
	 * @return	CookieManager
	 */
	public function getCookieManager() {
		return $this->cookieManager;
	}

	/**
	 * @brief	Recupera o host da conexão.
	 * @return	string
	 * @throws	BadMethodCallException Se a conexão não tiver
	 * sido inicializada.
	 */
	public function getHost() {
		if ( $this->initialized ) {
			$hostname = $this->getHostName();

			if ( ( $this->secure && $this->port != HTTPConnection::HTTPS_PORT ) || ( !$this->secure && $this->port != HTTPConnection::HTTP_PORT ) ) {
				return $hostname . ':' . $this->port;
			} else {
				return $hostname;
			}
		} else {
			throw new BadMethodCallException( 'Conexão não inicializada' );
		}
	}

	/**
	 * @brief	Recupera o nome do host.
	 * @return	string
	 * @throws	BadMethodCallException Se não houver uma conexão
	 * inicializada.
	 */
	public function getHostName() {
		if ( $this->initialized ) {
			return $this->hostname;
		} else {
			throw new BadMethodCallException( 'Conexão não inicializada' );
		}
	}

	/**
	 * @brief	Recupera a porta que será utilizada na conexão.
	 * @return	integer
	 * @throws	BadMethodCallException Se não houver uma conexão
	 * inicializada.
	 */
	public function getPort() {
		if ( $this->initialized ) {
			return $this->port;
		} else {
			throw new BadMethodCallException( 'Conexão não inicializada' );
		}
	}

	/**
	 * @brief	Recupera o timeout.
	 * @return	integer
	 */
	public function getTimeout() {
		return $this->timeout;
	}

	/**
	 * @brief	Recupera a URI que será utilizada na conexão.
	 * @return	string
	 * @throws	BadMethodCallException Se não houver uma conexão
	 * inicializada.
	 */
	public function getURI() {
		if ( $this->initialized ) {
			return sprintf( '%s://%s' , $this->isSecure() ? 'https' : 'http' , $this->getHost() );
		} else {
			throw new BadMethodCallException( 'Conexão não inicializada' );
		}
	}

	/**
	 * @brief	Inicializa a conexão HTTP.
	 * @param	string $hostname Servidor que receberá a requisição.
	 * @param	boolean $secure Indica se a conexão será segura (https).
	 * @param	integer $port Porta da requisição.
	 * @param	integer $connectionTimeout Timeout de conexão em segundos.
	 * @param	integer $timeout Timeout de espera em segundos.
	 */
	public function initialize( $hostname , $secure = false , $port = HTTPConnection::HTTP_PORT , $connectionTimeout = 0 , $timeout = 0 ) {
		if ( $this->initialized ) {
			$this->close();
		}

		$this->initialized = true;
		$this->hostname = $hostname;
		$this->secure = $secure === true;

		if ( func_num_args() == 2 ) {
			$this->port = $this->secure ? HTTPConnection::HTTPS_PORT : HTTPConnection::HTTP_PORT;
		} else {
			$this->port = (int) $port;
		}

		$this->connectionTimeout = (int) $connectionTimeout;
		$this->timeout = (int) $timeout;
	}

	/**
	 * @brief	Verifica se é uma conexão segura.
	 * @return	boolean
	 */
	public function isSecure() {
		return $this->secure === true;
	}

	/**
	 * @brief	Cria uma instância de um objeto de requisição HTTP.
	 * @return	HTTPRequest
	 */
	public function newRequest() {
		return new CURL();
	}

	/**
	 * @brief	Define um autenticador HTTP.
	 * @param	HTTPAuthenticator $httpAuthenticator
	 */
	public function setAuthenticator( HTTPAuthenticator $httpAuthenticator ) {
		$this->httpAuthenticator = $httpAuthenticator;
	}

	/**
	 * @brief	Define o timeout de conexão.
	 * @param	integer $connectionTimeout
	 * @throws	InvalidArgumentException Se $connectionTimeout não for um inteiro.
	 */
	public function setConnectionTimeout( $connectionTimeout ) {
		if ( is_integer( $connectionTimeout ) ) {
			$this->connectionTimeout = $connectionTimeout;
		} else {
			throw new InvalidArgumentException( '$connectionTimeout precisa ser o tempo em segundos.' );
		}
	}

	/**
	 * @brief	Define um gerenciador de cookies para essa conexão.
	 * @param	CookieManager $cookieManager
	 */
	public function setCookieManager( CookieManager $cookieManager ) {
		$this->cookieManager = $cookieManager;
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
	 */
	public function setParam( $name , $value = null ) {
		if ( is_scalar( $name ) && ( is_scalar( $value ) || is_null( $value ) ) ) {
			$this->requestParameter[ $name ] = $value;
		} else {
			throw new InvalidArgumentException( '$name e $value precisam ser strings.' );
		}
	}

	/**
	 * @brief	Define o corpo da requisição.
	 * @param	string $requestBody
	 */
	public function setRequestBody( $requestBody ) {
		$this->requestBody = $requestBody;
	}

	/**
	 * @brief	Define o timeout.
	 * @param	integer $timeout
	 * @throws	InvalidArgumentException Se $timeout não for um inteiro.
	 */
	public function setTimeout( $timeout ) {
		if ( is_integer( $timeout ) ) {
			$this->timeout = $timeout;
		} else {
			throw new InvalidArgumentException( '$timeout precisa ser o tempo em segundos.' );
		}
	}
}