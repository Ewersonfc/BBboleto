<?php 

namespace Ewersonfc\BBboleto\Services;

use StdClass;
use Ewersonfc\BBboleto\Entities\AvalistaEntity;
use Ewersonfc\BBboleto\Entities\OAuthEntity;
use Ewersonfc\BBboleto\Entities\DescontoEntity;
use Ewersonfc\BBboleto\Entities\JurosEntity;
use Ewersonfc\BBboleto\Entities\MultaEntity;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Exceptions\PagadorException;
use Ewersonfc\BBboleto\Exceptions\BoletoException;
use Ewersonfc\BBboleto\Requests\BoletoRequest;
use Ewersonfc\BBboleto\Responses\BoletoResponse;
use Ewersonfc\BBboleto\Soap\Config;
use Ewersonfc\BBboleto\Soap\Clients\BoletoClient;
use Ewersonfc\BBboleto\Soap\Factories\BoletoFactory;

/**
*
*
*
*/
class ServiceRegister
{

	/**
	*
	* @var Ewersonfc\BBboleto\Soap\Factories\BoletoFactory
	*/
	private $boletoFactory;

	/**
	*
	* @param Ewersonfc\BBboleto\Soap\Factories\BoletoFactory
	*/ 
	function __construct()
	{
		$this->boletoFactory = new BoletoFactory;
	}

	/**
	* 
	* Verify Error
	* @param [StdClass]
	*/
	private function verifyExistsError(StdClass $error)
	{
		if(!empty(trim($error->nomeProgramaErro)))
			throw new BoletoException($error->textoMensagemErro);
	}

	/**
	*
	* @param Ewersonfc\BBboleto\Requests\BoletoRequest
	* @param [StdClass]
	*/
	private function setResponse(BoletoRequest $boletoRequest, StdClass $objectBoleto)
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
			// ->setLogo();

		return $response;
	}

	/**
	*
	* @param Ewersonfc\BBboleto\Requests\BoletoRequest
	* @param Ewersonfc\BBboleto\Entities\OAuthEntity
	*/
	public function register(BoletoRequest $boletoRequest, OAuthEntity $oAuthEntity)
	{
		if(!$boletoRequest->getDesconto() instanceof DescontoEntity)
			$boletoRequest->setDesconto(new DescontoEntity());

		if(!$boletoRequest->getJuros() instanceof JurosEntity)
			$boletoRequest->setJuros(new JurosEntity());

		if(!$boletoRequest->getMulta() instanceof MultaEntity)
			$boletoRequest->setMulta(new MultaEntity());

		if(!$boletoRequest->getPagador() instanceof PagadorEntity)
			throw new PagadorException();

		if(!$boletoRequest->getAvalista() instanceof AvalistaEntity)
			$boletoRequest->setAvalista(new AvalistaEntity());

		$boletoBody = $this->boletoFactory->make($boletoRequest);

		try {
			$client = new BoletoClient($oAuthEntity);
			$body = $client->__soapCall('requisicao', $boletoBody, ['soapaction' => Config::FUNCTION_DEFAULT]);	
		} catch (\SoapFault $e) {
			throw new BoletoException($e->getMessage());
		}

		$this->verifyExistsError((object) $body);

		return $this->setResponse($boletoRequest, (object) $body);
	}
}
