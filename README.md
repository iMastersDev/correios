Cálculo de Preço e Prazo
========================

A biblioteca PHP para o Cálculo de preços e prazos do Correios facilita no cálculo de fretes de 1 ou de diversos serviços do Correios ao mesmo tempo.
Com a biblioteca o desenvolvedor utiliza uma interface simples, setando alguns parâmetros como altura, largura, comprimento, peso e indica o tipo de serviço que deseja calcular.
Todo o processo de integração é feito nos bastidores e o preço do frete e tempo de entrega é devolvido ao desenvolvedor para poder utilizar em sua aplicação sem o menor esforço.
O desenvolvedor pode calcular, de uma única vez, o preço do frete para os diversos serviços oferecidos pelo Correios, eliminando várias chamadas ao serviço e diminuindo o tempo de espera do cliente.

Instalar
--------

Instalação via [Composer](http://www.getcomposer.org)

	php composer.phar require imastersdev/correios

Como Usar ?
-----------

> A biblioteca pode fazer o cálculo de 1 serviço:

	<?php
	require_once 'vendor/autoload.php';
	
	$ect = new \Imasters\Php\Ect\ECT();
	$prdt = $ect->prdt();
	$prdt->setNVlAltura( 10 );
	$prdt->setNVlComprimento( 20 );
	$prdt->setNVlLargura( 20 );
	$prdt->setNCdFormato( \Imasters\Php\Ect\Prdt\ECTFormatos::FORMATO_CAIXA_PACOTE );
	$prdt->setNCdServico( \Imasters\Php\Ect\Prdt\ECTServicos::PAC ); //calculando apenas PAC
	$prdt->setSCepOrigem( '09641030' );
	$prdt->setSCepDestino( '27511300' );
	$prdt->setNVlPeso( 10 );
	
	foreach ( $prdt->call() as $servico ) {
		printf( "O preço do frete do correios para o serviço %d é R$ %.02f\n" , $servico->Codigo , $servico->Valor );
	}

> Ou de vários ao mesmo tempo, eliminando-se assim o tempo de espera do cliente:
	
	<?php
	require_once 'vendor/autoload.php';
	
	$ect = new \Imasters\Php\Ect\ECT();
	$prdt = $ect->prdt();
	$prdt->setNVlAltura( 10 );
	$prdt->setNVlComprimento( 20 );
	$prdt->setNVlLargura( 20 );
	$prdt->setNCdFormato( \Imasters\Php\Ect\Prdt\ECTFormatos::FORMATO_CAIXA_PACOTE );
	$prdt->setNCdServico( implode( ',' , array( \Imasters\Php\Ect\Prdt\ECTServicos::PAC , \Imasters\Php\Ect\Prdt\ECTServicos::SEDEX ) ) );
	$prdt->setSCepOrigem( '09641030' );
	$prdt->setSCepDestino( '27511300' );
	$prdt->setNVlPeso( 10 );
	
	foreach ( $prdt->call() as $servico ) {
		printf( "O preço do frete do correios para o serviço %d é R$ %.02f\n" , $servico->Codigo , $servico->Valor );
	}

http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=14335794&sDsSenha=70994140&sCepOrigem=30160041&sCepDestino=30180100&nVlPeso=1&nCdFormato=1&nVlComprimento=20&nVlAltura=10&nVlLargura=20&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=41106&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3