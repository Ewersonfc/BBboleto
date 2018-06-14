<?php
/**
 * Created by PhpStorm.
 * User: Ewerson
 * Date: 18/04/18
 * Time: 11:07
 */
namespace Ewersonfc\BBboleto;

use Ewersonfc\BBboleto\Requests\BoletoRequest;
use Ewersonfc\BBboleto\Services\ServiceAuthorization;
use Ewersonfc\BBboleto\Services\ServiceRegister;
use Ewersonfc\BBboleto\Validates\BancoDoBrasilValidate;

/**
 * Class Itau
 * @package Ewersonfc/BBboleto
 */
class BancoDoBrasil
{
	/**
	*
	* @var 
	*/
	private $authorization; 

	/**
	*
	* @param [array|config]
	* @return bool
	*/
  	function __construct(array $config)
	{
		$bancoDoBrasilValidate = new BancoDoBrasilValidate();
		$bancoDoBrasilValidate->config($config);

		$serviceAuthorization = new ServiceAuthorization();
		$this->authorization = $serviceAuthorization->authorize($config);
	}

	public function register(BoletoRequest $boletoRequest)
	{
    	$serviveRegister = new ServiceRegister();
    	$serviveRegister->register($boletoRequest, $this->authorization);
	}
}