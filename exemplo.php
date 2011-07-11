<?php
require_once 'com/imasters/php/ect/ECT.php';

$ect = new ECT();
$prdt = $ect->prdt();
$prdt->setNVlAltura( 10 );
$prdt->setNVlComprimento( 20 );
$prdt->setNVlLargura( 20 );
$prdt->setNCdFormato( ECTFormatos::FORMATO_CAIXA_PACOTE );
$prdt->setNCdServico( ECTServicos::PAC );
$prdt->setSCepOrigem( '09641030' );
$prdt->setSCepDestino( '27511300' );
$prdt->setNVlPeso( 10 );

foreach ( $prdt->call() as $servico ) {
	printf( "O preço do frete do correios é R$ %.02f\n" , $servico->Valor );
}