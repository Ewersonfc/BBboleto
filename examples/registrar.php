<?php
/**
 * Created by PhpStorm.
 * User: Ewerson
 * Date: 18/04/18
 * Time: 11:07
 */

require 'vendor/autoload.php';

use Ewersonfc\BBboleto\BancoDoBrasil;
use Ewersonfc\BBboleto\Constants\TipoDocumento;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Entities\BeneficiarioEntity;
use Ewersonfc\BBboleto\Entities\InstrucoesEntity;
use Ewersonfc\BBboleto\Exceptions\BoletoException;
use Ewersonfc\BBboleto\Requests\BoletoRequest;

$bancoDoBrasil = new BancoDoBrasil([
	'clientId' => 'xx',
	'clientSecret' => 'xx',
	'production' => false,
	'formato' => 'html',
	
]);
	
$beneficiario = new BeneficiarioEntity;
$beneficiario->setTipoDocumento(TipoDocumento::CNPJ)
	->setDocumento('62.999.992\0001-60')
	->setNome('E-htl Viagens On-line');


$pagador = new PagadorEntity;
$pagador->setTipoDocumento(TipoDocumento::CNPJ)
	->setDocumento('62.999.992\0001-60')
	->setNome('E-htl Viagens On-line')
	->setLogradouro('Avenida Ipiranga, n° 104')
	->setCep(01046010)
	->setMunicipio('São Paulo')
	->setBairro('República')
	->setUf('SP')
	->setTelefone(1131365858); 

$instrucoes = new InstrucoesEntity;
$instrucoes->setInstrucoes([
	'- instrução 1',
	'- instrução teste 2',
	'- instrução teste 3',
])
->setDemonstrativo("Demonstrativo teste");


$boletoRequest = new BoletoRequest();
$boletoRequest->setConvenio(2625444)
	->setCarteira(17) 
	->setVariacaoCarteira(19) 
	->setDataEmissao('2018-05-01') 
	->setDataVencimento('15/07/2018') 
	->setValorOriginal('300,00') 
	->setDescricaoTipoTitulo("Texto livre")
	->setSeuNumero('987654321987654') 
	->setCampoUtilizacaoBeneficiario('0000000')
	->setNossoNumero('0000000207')
	->setPagador($pagador)
	->setBeneficiario($beneficiario)
	->setInstrucoes($instrucoes);

$data = $bancoDoBrasil->register($boletoRequest);
print_r(json_decode($data));
