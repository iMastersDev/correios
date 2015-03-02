<?php

namespace D4w\Ect;

abstract class Tabela
{
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