<?php 

namespace Ewersonfc\BBboleto\Factories;

use StdClass;
use Ewersonfc\BBboleto\Requests\BoletoRequest;
use Ewersonfc\BBboleto\Responses\BoletoResponse;

class BoletoResponseFactory
{
	/**
	*
	* @param Ewersonfc\BBboleto\Requests\BoletoRequest
	* @param StdClass
	*/
	public function make(BoletoRequest $boletoRequest, StdClass $objectBoleto)
	{
		$response = new BoletoResponse;
		$response->setNossoNumero($boletoRequest->getNossoNumero())
			->setInicioNossoNumero('000')
			->setNumeroDocumento($boletoRequest->getNossoNumero())
			->setVencimento($boletoRequest->getDataVencimento()->format('d/m/Y'))
			->setEmissao($boletoRequest->getDataEmissao()->format('d/m/Y'))
			->setProcessamento($boletoRequest->getDataEmissao()->format('d/m/Y'))
			->setValor($boletoRequest->getValorOriginal())
			->setConvenio($boletoRequest->getConvenio())
			->setCarteira($boletoRequest->getCarteira())
			->setVariacaoCarteira($boletoRequest->getVariacaoCarteira())
			->setPagador($boletoRequest->getPagador())
			->setDemonstrativo($boletoRequest->getDescricaoTipoTitulo())
			->setInstrucoes($boletoRequest->getInstrucoes())
			->setAceite($boletoRequest->getAceite())
			->setAgencia($objectBoleto->codigoPrefixoDependenciaBeneficiario)
			->setConta($objectBoleto->numeroContaCorrenteBeneficiario)
			->setContaDigito('0')
			->setNomeBeneficiario('Ewerson Carvalho')
			->setDocumento('01011010000108')
			->setEndereco($objectBoleto->nomeLogradouroBeneficiario)
			->setCidade($objectBoleto->nomeMunicipioBeneficiario)
			->setUf($objectBoleto->siglaUfBeneficiario);

		return $response;	
	}
}