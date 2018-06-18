<?php
/**
 * Created by PhpStorm.
 * User: Ewerson
 * Date: 18/04/18
 * Time: 11:07
 */
namespace Ewersonfc\BBboleto;

use Ewersonfc\BBboleto\Constants\Formato;
use Ewersonfc\BBboleto\Exceptions\BoletoException;
use Ewersonfc\BBboleto\Helpers\Fractal;
use Ewersonfc\BBboleto\Requests\BoletoRequest;
use Ewersonfc\BBboleto\Responses\BoletoResponse;
use Ewersonfc\BBboleto\Services\ServiceAuthorization;
use Ewersonfc\BBboleto\Services\ServiceRegister;
use Ewersonfc\BBboleto\Services\ServiceLayoutBoleto;
use Ewersonfc\BBboleto\Transformers\BoletoTransformer;
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
	* @var 
	*/
	private $config;

	/**
	*
	* @param [array|config]
	* @return bool
	*/
  	function __construct(array $config)
	{
		$bancoDoBrasilValidate = new BancoDoBrasilValidate();
		$bancoDoBrasilValidate->config($config);

		$this->config = $config;

		$serviceAuthorization = new ServiceAuthorization();
		$this->authorization = $serviceAuthorization->authorize($config);
	}

	public function register(BoletoRequest $boletoRequest)
	{
    	$serviveRegister = new ServiceRegister();
    	$boleto = $serviveRegister->register($boletoRequest, $this->authorization);
    	$boleto->setLogo(array_get($this->config, 'logo', false));

    	if(!$boleto instanceof BoletoResponse)
    		throw new BoletoException("Não foi possivel gerar boleto");

    	if(array_get($this->config, 'formato') == Formato::PDF) 
    		return (new ServiceLayoutBoleto)->dataToPdf($boleto);

    	if(array_get($this->config, 'formato') == Formato::HTML) 
    		return (new ServiceLayoutBoleto)->dataToHtml($boleto);

    	return Fractal::collection($boleto, new BoletoTransformer());
	}
}