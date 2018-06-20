# Boleto Itaú
[![Latest Stable Version](https://poser.pugx.org/matheushack/itauboleto/v/stable)](https://packagist.org/packages/ewersonfc/bbboleto)
[![Latest Unstable Version](https://poser.pugx.org/matheushack/itauboleto/v/unstable)](https://packagist.org/packages/ewersonfc/bbboleto)
[![Total Downloads](https://poser.pugx.org/matheushack/itauboleto/downloads)](https://packagist.org/packages/ewersonfc/bbboleto)
[![License](https://poser.pugx.org/matheushack/itauboleto/license)](https://packagist.org/packages/ewersonfc/bbboleto)
 

Projeto para integração com módulo de cobrança do banco Itaú.

## Instalação
### Composer
```
"ewersonfc/bbboleto": "^1.0"
```

## Como usar
```php
require 'vendor/autoload.php';

use Ewersonfc\BBboleto\BancoDoBrasil;
use Ewersonfc\BBboleto\Constants\TipoDocumento;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Exceptions\BoletoException;
use Ewersonfc\BBboleto\Requests\BoletoRequest;

$bancoDoBrasil = new BancoDoBrasil([
	'clientId' => 'xxxxxxxxxxxxxxxx',
	'clientSecret' => 'xxxxxxxxxxxx',
	'production' => false,
	'formato' => 'pdf ou html',
]);
	
$pagador = new PagadorEntity;
$pagador->setTipoDocumento(TipoDocumento::CNPJ)
	->setDocumento('73.553.069/0001-16')
	->setNome('Empresa Ficticia')
	->setLogradouro('Avenida Teste, n° 10')
	->setCep(02015230)
	->setMunicipio('Teste')
	->setBairro('Teste')
	->setUf('SP')
	->setTelefone(118888888); 

$boletoRequest = new BoletoRequest();
$boletoRequest->setConvenio(xxxxxx)
	->setCarteira(xx) 
	->setVariacaoCarteira(xx) 
	->setDataEmissao('2018-05-01') 
	->setDataVencimento('15/07/2018') 
	->setValorOriginal('300.00') 
	->setDescricaoTipoTitulo("Texto livre")
	->setSeuNumero('987654321987654') // numero para controle 
	->setCampoUtilizacaoBeneficiario('0000000')
	->setCodigoTipoContaCaucao(1)
	->setNossoNumero('0000000197') // nosso número sequencial do banco 
	->setPagador($pagador); 

$data = $bancoDoBrasil->register($boletoRequest);
echo $data;
```
