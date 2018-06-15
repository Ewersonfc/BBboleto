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
use Ewersonfc\BBboleto\Soap\Config;
use Ewersonfc\BBboleto\Soap\Clients\BoletoClient;
use Ewersonfc\BBboleto\Soap\Factories\BoletoFactory;


use GuzzleHttp\Client;
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
		if(isset($error->nomeProgramaErro))
			throw new BoletoException($error->textoMensagemErro);
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

		dd($client);
		$bodyValid = $this->verifyExistsError((object) $body);

		return $bodyValid;
	}
}