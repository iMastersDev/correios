<?php

namespace D4w\Ect;

abstract class Tabela
{
	const CSV_DELIMITER = ';';
	const CSV_ENCLOSURE = '';
	const CSV_ESCAPE 	= '';

	const CSV_ESTADO 			= 0;
	const CSV_TIPO 				= 1; // capital ou interior
	const CSV_FAIXA_PESO_INI 	= 2;
	const CSV_FAIXA_PESO_FIM 	= 3;
	const CSV_LOCAL				= 4;
	const CSV_ESTADUAL			= 5;
	const CSV_F1				= 6;
	const CSV_F2				= 7;
	const CSV_F3				= 8;
	const CSV_F4				= 9;
	const CSV_F5				= 10;
	const CSV_F6				= 11;

	/**
	 * Cep de origem
	 * @var string
	 */
	protected $cep_origem;

	/**
	 * Estado do cep de origem
	 * @var string
	 */
	protected $estado_origem;

	/**
	 * Faixa de peso inicial
	 * @var array
	 */
	protected $peso_ini;

	/**
	 * Faixa de peso final
	 * @var array
	 */
	protected $peso_fim;

	/**
	 * Tarifa local
	 * @var array
	 */
	protected $local;


	/**
	 * Tarifa estadual
	 * @var array
	 */
	protected $estadual;

	/**
	 * Faixa 1
	 * @var array
	 */
	protected $faixa1;

	/**
	 * Faixa 2
	 * @var array
	 */
	protected $faixa2;

	/**
	 * Faixa 3
	 * @var array
	 */
	protected $faixa3;

	/**
	 * Faixa 4
	 * @var array
	 */
	protected $faixa4;

	/**
	 * Faixa 5
	 * @var array
	 */
	protected $faixa5;

	/**
	 * Faixa 6
	 * @var array
	 */
	protected $faixa6;

}