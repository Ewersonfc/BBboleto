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
use Ewersonfc\BBboleto\Exceptions\BoletoException;
use Ewersonfc\BBboleto\Requests\BoletoRequest;

$bancoDoBrasil = new BancoDoBrasil([
	'clientId' => 'eyJpZCI6IjgwNDNiNTMtZjQ5Mi00YyIsImNvZGlnb1B1YmxpY2Fkb3IiOjEwOSwiY29kaWdvU29mdHdhcmUiOjEsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxfQ',
	'clientSecret' => 'eyJpZCI6IjBjZDFlMGQtN2UyNC00MGQyLWI0YSIsImNvZGlnb1B1YmxpY2Fkb3IiOjEwOSwiY29kaWdvU29mdHdhcmUiOjEsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MX0',
	'production' => false,
	'formato' => 'pdf',
	
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

$boletoRequest = new BoletoRequest();
$boletoRequest->setConvenio(2625444)
	->setCarteira(17) 
	->setVariacaoCarteira(19) 
	->setDataEmissao('2018-05-01') 
	->setDataVencimento('15/07/2018') 
	->setValorOriginal('300.00') 
	->setDescricaoTipoTitulo("Texto livre")
	->setSeuNumero('987654321987654') 
	->setCampoUtilizacaoBeneficiario('0000000')
	->setNossoNumero('0000000198')
	->setPagador($pagador)
	->setBeneficiario($beneficiario);

$data = $bancoDoBrasil->register($boletoRequest);
echo $data;
