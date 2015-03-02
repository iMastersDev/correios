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
		$fp = fopen($csv, 'r');
		if (!$fp)
			thrown new \RuntimeException('Não foi possível abrir o arquivo informado "' . $csv . '".' );
		while (($data = fgetcsv($fp, 0, Tabela::CSV_DELIMITER, Tabela::CSV_ENCLOSURE, Tabela::CSV_ESCAPE)) !== FALSE) {
			if (!$this->estado_origem)
				$this->estado_origem = $data[Tabela::CSV_ESTADO];
			
			$tipo = $data[Tabela::CSV_TIPO];

			$this->local[$tipo][] 		= $data[Tabela::CSV_LOCAL];
			$this->estadual[$tipo][] 	= $data[Tabela::CSV_ESTADUAL];
			$this->faixa1[$tipo][]	= $data[Tabela::CSV_F1];
			$this->faixa2[$tipo][]	= $data[Tabela::CSV_F2];
			$this->faixa3[$tipo][]	= $data[Tabela::CSV_F3];
			$this->faixa4[$tipo][]	= $data[Tabela::CSV_F4];
			$this->faixa5[$tipo][]	= $data[Tabela::CSV_F5];
			$this->faixa6[$tipo][]	= $data[Tabela::CSV_F6];
		}
	}

	public function calculate($cep_destino, $peso)
	{
		$estado_destino = \D4w\Ect\Cep\Faixas::getEstado($cep_destino);
		$is_local = $this->estado_origem === $estado_destino;
		$is_capital = \D4w\Ect\Cep\Faixas::isCapital($this->cep_origem) && \D4w\Ect\Cep\Faixas::isCapital($cep_destino);
		
	}
}