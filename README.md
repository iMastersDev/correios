Cálculo de Preço e Prazo
========================

A biblioteca PHP para o Cálculo de preços e prazos do Correios facilita no cálculo de fretes de 1 ou de diversos serviços do Correios ao mesmo tempo.
Com a biblioteca o desenvolvedor utiliza uma interface simples, setando alguns parâmetros como altura, largura, comprimento, peso e indica o tipo de serviço que deseja calcular.
Todo o processo de integração é feito nos bastidores e o preço do frete e tempo de entrega é devolvido ao desenvolvedor para poder utilizar em sua aplicação sem o menor esforço.
O desenvolvedor pode calcular, de uma única vez, o preço do frete para os diversos serviços oferecidos pelo Correios, eliminando várias chamadas ao serviço e diminuindo o tempo de espera do cliente.

Como Usar ?
-----------

> A biblioteca pode fazer o cálculo de 1 serviço:
```php
<?php
require_once 'com/imasters/php/ect/ECT.php';

$ect = new ECT();
$prdt = $ect->prdt();
$prdt->setNVlAltura( 10 );
$prdt->setNVlComprimento( 20 );
$prdt->setNVlLargura( 20 );
$prdt->setNCdFormato( ECTFormatos::FORMATO_CAIXA_PACOTE );
$prdt->setNCdServico( ECTServicos::PAC ); //calculando apenas PAC
$prdt->setSCepOrigem( '09641030' );
$prdt->setSCepDestino( '27511300' );
$prdt->setNVlPeso( 10 );

foreach ( $prdt->call() as $servico ) {
	printf( "O preço do frete do correios para o serviço %d é R$ %.02f\n" , $servico->Codigo , $servico->Valor );
}
```
> Ou de vários ao mesmo tempo, eliminando-se assim o tempo de espera do cliente:
```php	
<?php
require_once 'com/imasters/php/ect/ECT.php';

$ect = new ECT();
$prdt = $ect->prdt();
$prdt->setNVlAltura( 10 );
$prdt->setNVlComprimento( 20 );
$prdt->setNVlLargura( 20 );
$prdt->setNCdFormato( ECTFormatos::FORMATO_CAIXA_PACOTE );
$prdt->setNCdServico( implode( ',' , array( ECTServicos::PAC , ECTServicos::SEDEX ) ) );
$prdt->setSCepOrigem( '09641030' );
$prdt->setSCepDestino( '27511300' );
$prdt->setNVlPeso( 10 );

foreach ( $prdt->call() as $servico ) {
	printf( "O preço do frete do correios para o serviço %d é R$ %.02f\n" , $servico->Codigo , $servico->Valor );
}
```
