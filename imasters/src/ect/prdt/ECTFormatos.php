<?php
/**
 * @brief	Biblioteca Correios para cálculo de preços e prazos
 * @details	Classes e interfaces para integração com a API do Correios
 * @package com.imasters.php.ect.prdt
 */

/**
 * @brief	Tipos de formato de encomenda
 * @author	João Batista Neto <neto.joaobatista@imasters.com.br>
 */
interface ECTFormatos {
	const FORMATO_CAIXA_PACOTE	= 1;
	const FORMATO_ROLO_PRISMA	= 2;
}