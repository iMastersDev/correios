<?php
/**
 * @brief	Biblioteca Correios para cálculo de preços e prazos
 * @details	Classes e interfaces para integração com a API do Correios
 * @package com.imasters.php.ect.prdt
 */

/**
 * @brief	Informações sobre preço e prazo cobrados para um serviço do Correios
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 */
class ECTServico {
	/**
	 * Código do serviço
	 * @var integer
	 */
	public $Codigo;

	/**
	 * Valor do serviço adicional de mão própria
	 * @var float
	 */
	public $ValorMaoPropria;

	/**
	 * Valor do serviço adicional de aviso de recebimento
	 * @var float
	 */
	public $ValorAvisoRecebimento;

	/**
	 * Valor do serviço adicional de valor declarado
	 * @var float
	 */
	public $ValorValorDeclarado;

	/**
	 * Prazo de entrega para a encomenda
	 * @var integer
	 */
	public $PrazoEntrega;

	/**
	 * Informa se a localização possui entrega domiciliar
	 * @var boolean
	 */
	public $EntregaDomiciliar;

	/**
	 * Informa se existe entrega aos sábados
	 * @var boolean
	 */
	public $EntregaSabado;

	/**
	 * Código do erro para o serviço, se não tiver ocorrido nenhum erro esse valor será 0
	 * @var integer
	 */
	public $Erro = 0;

	/**
	 * Mensagem de erro para o serviço, se não tiver ocorrido nenhum erro esse valor será NULL
	 * @var string
	 */
	public $MsgErro;
}