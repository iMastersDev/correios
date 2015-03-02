<?php

namespace D4w\Ect;

interface TabelaLoaderInterface
{
	public function load($csv);

	public function calculate($cep_destino, $peso);
}