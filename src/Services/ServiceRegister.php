<?php 

namespace Ewersonfc\BBboleto\Services;

use Ewersonfc\BBboleto\Entities\OAuthEntity;
use Ewersonfc\BBboleto\Requests\BoletoRequest;
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
	function __construct(BoletoFactory $boletoFactory)
	{
		$this->boletoFactory = $boletoFactory;
	}

	/**
	*
	* @param Ewersonfc\BBboleto\Requests\BoletoRequest
	* @param Ewersonfc\BBboleto\Entities\OAuthEntity
	*/
	public function register(BoletoRequest $boletoRequest, OAuthEntity $authorization)
	{

	}
}