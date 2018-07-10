<?php 

namespace Ewersonfc\BBboleto\Services;

use Ewersonfc\BBboleto\Entities\OAuthEntity;
use Ewersonfc\BBboleto\Clients\BancoDoBrasilAuthorizationClient;
/**
*
*
*
*/
class ServiceAuthorization
{
	public function authorize(array $config)
	{
		$authorize = (new BancoDoBrasilAuthorizationClient($config))
			->__callBancoDoBrasil();
		
		$oAuthEntity = new OAuthEntity;
		$oAuthEntity->setAccessToken($authorize->access_token)
		    ->setEnvironment(array_get($config, 'production', false));

		return $oAuthEntity;
		
	}
}
