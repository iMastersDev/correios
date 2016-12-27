<?php
require_once 'vendor/autoload.php';

use Imasters\ect\ECT;
use Imasters\ect\prdt\ECTFormatos;
use Imasters\ect\prdt\ECTServicos;

$ect = new ECT();
$prdt = $ect->prdt();
$prdt->setNVlAltura( 10 );
$prdt->setNVlComprimento( 20 );
$prdt->setNVlLargura( 20 );
$prdt->setNCdFormato( ECTFormatos::FORMATO_CAIXA_PACOTE );
$prdt->setNCdServico( ECTServicos::PAC );
$prdt->setSCepOrigem( '88509000' );
$prdt->setSCepDestino( '27511300' );
$prdt->setNVlPeso( 10 );

foreach ( $prdt->call() as $servico ) {
	printf( "O preço do frete do correios é R$ %.02f\n" , $servico->Valor );
}