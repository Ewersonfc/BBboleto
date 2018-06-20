<?php 

namespace Ewersonfc\BBboleto\Services;

use StdClass;
use Ewersonfc\BBboleto\Entities\OAuthEntity;
use Ewersonfc\BBboleto\Entities\InstrucoesEntity;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Entities\BeneficiarioEntity;
use Ewersonfc\BBboleto\Exceptions\PagadorException;
use Ewersonfc\BBboleto\Exceptions\BoletoException;
use Ewersonfc\BBboleto\Exceptions\BeneficiarioException;
use Ewersonfc\BBboleto\Factories\BoletoResponseFactory;
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
	* @var Ewersonfc\BBboleto\Factories\BoletoResponseFactory
	*/
	private $boletoResponseFactory;

	/**
	*
	* @param Ewersonfc\BBboleto\Soap\Factories\BoletoFactory
	*/ 
	function __construct()
	{
		$this->boletoFactory = new BoletoFactory;
		$this->boletoResponseFactory = new BoletoResponseFactory;
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
		return $this->boletoResponseFactory->make($boletoRequest, $objectBoleto);
	}

	/**
	*
	* @param Ewersonfc\BBboleto\Requests\BoletoRequest
	* @param Ewersonfc\BBboleto\Entities\OAuthEntity
	*/
	public function register(BoletoRequest $boletoRequest, OAuthEntity $oAuthEntity)
	{

		if(!$boletoRequest->getPagador() instanceof PagadorEntity)
			throw new PagadorException();

		if(!$boletoRequest->getBeneficiario() instanceof BeneficiarioEntity)
			throw new BeneficiarioException();

		if(!$boletoRequest->getInstrucoes() instanceof InstrucoesEntity)
			$boletoRequest->setInstrucoes(new InstrucoesEntity());


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
