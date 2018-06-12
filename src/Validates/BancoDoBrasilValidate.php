<?php 
/**
 * Created by PhpStorm.
 * User: ewerson
 * Date: 12/06/2018
 * Time: 11:14
 */
namespace Ewersonfc\BBboleto\Validates;

/**
 * Class BoletoValidate
 * @package MatheusHack\ItauBoleto\Validates
 */
class BancoDoBrasilValidate
{
    /**
     * @param array $config
     * @throws ValidationException
     */
    public function config($config = [])
    {
        if(empty($config))
            throw new ValidationException('Necessário passar os dados de configuração para geração do boleto');

        if(!data_get($config, 'clientId'))
            throw new ValidationException('A configuração clientId é obrigatória');

        if(!data_get($config, 'clientSecret'))
            throw new ValidationException('A configuração clientSecret é obrigatória');
    }
}
