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
 * Class BancoDoBrasil
 * @package Ewersonfc/BBboleto
 */
class BancoDoBrasil
{
    /**
     * @var Entities\OAuthEntity 
     */
	private $authorization;

    /**
     * @var array
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

    /**
     * @param BoletoRequest $boletoRequest
     * @return mixed
     * @throws BoletoException
     */
	public function register(BoletoRequest $boletoRequest)
	{
    	$serviveRegister = new ServiceRegister();
    	$boleto = $serviveRegister->register($boletoRequest, $this->authorization);
    	$boleto->setLogo(array_get($this->config, 'logo', 'http://placehold.it/200&text=logo'));

    	if(!$boleto instanceof BoletoResponse)
    		throw new BoletoException("Não foi possivel gerar boleto");

    	$data = null;
    	if(array_get($this->config, 'formato') == Formato::PDF) 
    		$data = (new ServiceLayoutBoleto)->dataToPdf($boleto);

    	if(array_get($this->config, 'formato') == Formato::HTML) 
    		$data = (new ServiceLayoutBoleto)->dataToHtml($boleto);

	   	$serialize = Fractal::item($boleto, new BoletoTransformer($this->config, $data));
	   	
	   	return $serialize->toJson();
	}
}