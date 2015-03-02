<?php

namespace D4w\Ect;

class TabelaPac extends Tabela implements TabelaLoaderInterface
{
	public function __construct($cep_origem, $csv = null)
	{
		$this->cep_origem = $cep_origem;
		
		if (file_exists($csv)) {
			$this->load($csv);
		}
	}

	/**
	 * Carrega tarifas do arquivo csv no formato requerido
	 * @param  string $csv Caminho do arquivo csv
	 * @return void
	 */
	public function load($csv)
	{

	}

	public function calculate($cep_destino, $peso)
	{

	}
}