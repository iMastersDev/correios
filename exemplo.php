<?php
require_once 'vendor/autoload.php';

$ect = new \Imasters\Php\Ect\ECT();
$prdt = $ect->prdt();
$prdt->setNVlAltura( 10 );
$prdt->setNVlComprimento( 20 );
$prdt->setNVlLargura( 20 );
$prdt->setNCdFormato( \Imasters\Php\Ect\Prdt\ECTFormatos::FORMATO_CAIXA_PACOTE );
$prdt->setNCdServico( \Imasters\Php\Ect\Prdt\ECTServicos::PAC );
$prdt->setSCepOrigem( '09641030' );
$prdt->setSCepDestino( '27511300' );
$prdt->setNVlPeso( 10 );

foreach ( $prdt->call() as $servico ) {
	printf( "O preço do frete do correios é R$ %.02f\n" , $servico->Valor );
}