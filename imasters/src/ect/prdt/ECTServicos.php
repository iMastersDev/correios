<?php
/**
 * @brief	Biblioteca Correios para cálculo de preços e prazos
 * @details	Classes e interfaces para integração com a API do Correios
 * @package com.imasters.php.ect.prdt
 */

/**
 * @brief	Tipos de serviços oferecidos pelo Correios
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 */
interface ECTServicos {
	/**
	 * e-SEDEX, com contrato
	 */
	const E_SEDEX			= 81019;

	/**
	 * Malote
	 */
	const MALOTE			= 44105;

	/**
	 * Normal
	 */
	const NORMAL			= 41017;

	/**
	 * PAC sem contrato
	 */
	const PAC				= 41106;

	/**
	 * PAC com contrato
	 */
	const PAC_CONTRATO		= 41068;

	/**
	 * SEDEX sem contrato
	 */
	const SEDEX				= 40010;

	/**
	 * SEDEX a cobrar, sem contrato
	 */
	const SEDEX_A_COBRAR	= 40045;

	/**
	 * SEDEX 10, sem contrato
	 */
	const SEDEX_10			= 40215;

	/**
	 * SEDEX Hoje, sem contrato
	 */
	const SEDEX_HOJE		= 40290;

	/**
	 * SEDEX com contrato
	 */
	const SEDEX_CONTRATO_1	= 40096;

	/**
	 * SEDEX com contrato
	 */
	const SEDEX_CONTRATO_2	= 40436;

	/**
	 * SEDEX com contrato
	 */
	const SEDEX_CONTRATO_3	= 40444;
}