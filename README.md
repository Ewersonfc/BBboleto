# Boleto Registrado Banco do Brasil via Webservice
[![Latest Stable Version](https://poser.pugx.org/ewersonfc/bbboleto/v/stable)](https://packagist.org/packages/ewersonfc/bbboleto)
[![Latest Unstable Version](https://poser.pugx.org/ewersonfc/bbboleto/v/unstable)](https://packagist.org/packages/ewersonfc/bbboleto)
[![Total Downloads](https://poser.pugx.org/ewersonfc/bbboleto/downloads)](https://packagist.org/packages/ewersonfc/bbboleto)
[![License](https://poser.pugx.org/ewersonfc/bbboleto/license)](https://packagist.org/packages/ewersonfc/bbboleto)
 

Integração com Webservice Banco do Brasil para registro de Títulos/Boletos

## Instalação
### Composer
```
composer require ewersonfc/bbboleto
```
Se preferir, você pode adicionar direto no seu arquivo composer.json.

```
"ewersonfc/bbboleto": "^1.0.4"
```
## Como usar
```php
require 'vendor/autoload.php';

use Ewersonfc\BBboleto\BancoDoBrasil;
use Ewersonfc\BBboleto\Constants\TipoDocumento;
use Ewersonfc\BBboleto\Entities\BeneficiarioEntity;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Exceptions\BoletoException;
use Ewersonfc\BBboleto\Requests\BoletoRequest;

$bancoDoBrasil = new BancoDoBrasil([
	'clientId' => 'xxxxxxxxxxxxxxxx',
	'clientSecret' => 'xxxxxxxxxxxx',
	'production' => false,
	'formato' => 'pdf ou html',
]);

$beneficiario = new BeneficiarioEntity;
$beneficiario->setTipoDocumento(TipoDocumento::CNPJ)
	->setDocumento('73.553.069/0001-16')
	->setNome('Empresa Fictícia Beneficiario');
	
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
## Instruções

Para adicionar instruções que são impressas no boleto, é necessário preencher a entidade Instruções e "setar" no BoletoRequest.

As instruções adicionadas abaixo serão impressas no boleto, elas estão relacionadas ao desconto, juros, multa e qualquer tipo de especificidade ligada a informação que deve ser apresentada ao pagador.
```php
// ... code
use Ewersonfc\BBboleto\Entities\InstrucoesEntity

$instrucoes = new InstrucoesEntity;
$instrucoes->setInstrucoes([
	'- instrução 1',
	'- instrução teste 2',
	'- instrução teste 3',
])->setDemonstrativo("Demonstrativo teste");

$boletoRequest = new BoletoRequest();
	//... outros set's
	->setInstrucoes($instrucoes)
	// ... 

```

## Desconto
Para adicionar a instrução de desconto em seu boleto é necessário preencher a entendidade Desconto e "setar" no BoletoRequest.

Nota: O desconto é opcional, caso não tenha desconto no título não há necessidade de preencher esta entidade e tbm não há necessidade de "setar" no Request

```php
// ... code
use Ewersonfc\BBboleto\Entities\DescontoEntity;
use Ewersonfc\BBboleto\Constants\Desconto;

$desconto = new DescontoEntity;
$desconto->setTipo(Desconto::VALOR)
	->setData('10/07/2018')
	->setValor('5.00');

$boletoRequest = new BoletoRequest();
	//... outros set's
	->setDesconto($desconto)
	// ... 
```

## Juros
Para adicionar a instrução de juros em seu boleto é necessário preencher a entendidade Juros e "setar" no BoletoRequest.

Juros possui uma combinação de valores informados que se passados de forma incorreta o Banco não aceitará os dados e consequentemente não irá registrar o boleto.

Nota: O Juros é opcional, caso não tenha desconto no título não há necessiade de preencher esta entidade e tbm não há necessidade de "setar" no Request

```php
// ... code
use Ewersonfc\BBboleto\Entities\JurosEntity;
use Ewersonfc\BBboleto\Constants\Juros;

// ... code 
$juros = new JurosEntity;
$juros->setTipo(Juros::VALOR_POR_DIA_DE_ATRASO)
	->setValor('10.00');

$boletoRequest = new BoletoRequest();
	//... outros set's
	->setJuros($juros)
	// ... 
```
## Multa
Para adicionar a instrução de multa em seu boleto é necessário preencher a entendidade Multa e "setar" no BoletoRequest.

A Multa assim como o Juros possui uma combinação de valores informados que se passados de forma incorreta o Banco não aceitará os dados e consequentemente não irá registrar o boleto.

Nota: A Multa é opcional, caso não tenha desconto no título não há necessiade de preencher esta entidade e tbm não há necessidade de "setar" no Request

```php
// ... code
use Ewersonfc\BBboleto\Entities\MultaEntity;
use Ewersonfc\BBboleto\Constants\Multa;

// ... code 
$multa = new MultaEntity;
$multa->setTipo(Multa::VALOR)
	->setValor('10.00');

$boletoRequest = new BoletoRequest();
	//... outros set's
	->setMulta($multa)
	// ... 
```

## Avalista
Para adicionar avalista em seu boleto é necessário preencher a entendidade Multa e "setar" no BoletoRequest.

Nota: O Avalista é opcional, caso não tenha desconto no título não há necessiade de preencher esta entidade e tbm não há necessidade de "setar" no Request

```php
// ... code
use Ewersonfc\BBboleto\Constants\TipoDocumento;
use Ewersonfc\BBboleto\Entities\AvalistaEntity;

// ... code 
$avalista = new AvalistaEntity;
$avalista->setTipoDocumento(TipoDocumento::CNPJ)
	->setDocumento('09.123.123\0001-81')
	->setNome('Ewerson Carvalho');

$boletoRequest = new BoletoRequest();
	//... outros set's
	->setAvalista($avalista)
	// ... 
```
