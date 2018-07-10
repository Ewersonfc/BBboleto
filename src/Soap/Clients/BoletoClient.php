<?php 

namespace Ewersonfc\BBboleto\Soap\Clients;

use SoapClient;
use Ewersonfc\BBboleto\Entities\OAuthEntity;
use Ewersonfc\BBboleto\Soap\Config;

class BoletoClient extends SoapClient
{

    /**
     * BoletoClient constructor.
     * @param OAuthEntity $oAuthEntity
     */
	function __construct(OAuthEntity $oAuthEntity)
	{
	    $wsdl = $oAuthEntity->getEnvironment() == false? Config::WSDL_HM : Config::WSDL_PRODUCTION;

		parent::__construct(null, [			
			'exceptions' => 0,
            'location' => $wsdl,
    		'trace' => 1,
            'uri' => Config::NAMESPACE,
    		'connection_timeout' => 1800,
    		'soap_version' => SOAP_1_1,
    		'use' => SOAP_LITERAL,
    		'compression' =>  SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
    		'stream_context' => stream_context_create([
				'http' => [
					'header' => "Authorization: Bearer {$oAuthEntity->getAccessToken()}"
				],
				'ssl' => [
					'verify_peer' => false,
					'allow_self_signed' => true
				],
			])
		]);
	}
}