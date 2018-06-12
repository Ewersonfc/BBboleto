<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 18/04/18
 * Time: 10:21
 */
namespace Ewersonfc\BBboleto;

use Ewersonfc\BBboleto\Services\ServiceAuthorization;
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

    public function register()
    {
    	
    }
}