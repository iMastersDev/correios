<?php

namespace D4w\Ect;

interface TabelaLoaderInterface
{
	/**
	 * Carregar tabela
	 * @param  string $csv Caminho do arquivo csv com a tabela
	 * @throws \RuntimeException Se nao puder carregar o arquivo csv
	 * @return void
	 */
	public function load($csv);

	/**
	 * Calcular frete conforme tabela carregada
	 * @param  string $cep_destino CEP de destino da encomenda
	 * @param  float $peso        Peso em kg
	 * @return float
	 */
	public function calculate($cep_destino, $peso);
}