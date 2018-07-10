<?php

namespace Ewersonfc\BBboleto\Clients;


use Ewersonfc\BBboleto\Exceptions\OAuthException;
use GuzzleHttp\Client;

/**
 * Class BancoDoBrasilAuthorizationClient
 * @package Ewersonfc\BBboleto\Clients
 */
class BancoDoBrasilAuthorizationClient
{

	const OAUTH_HM = 'https://oauth.hm.bb.com.br/oauth/token';

	const OAUTH_PRODUCTION = 'https://oauth.bb.com.br/oauth/token';

	const SCOPE = 'cobranca.registro-boletos';

	const GRANT_TYPE = 'client_credentials';

    /**
     * @var Client
     */
	private $httpClient;

    /**
     *
     * Constructor method
     * @param array $config
     */
	function __construct(array $config)
	{
		$this->httpClient = new Client();

		$this->clientId = array_get($config, 'clientId', null);
		$this->clientSecret = array_get($config, 'clientSecret', null);
		$this->oAuthUrl = array_get($config, 'production', false) == false? self::OAUTH_HM : self::OAUTH_PRODUCTION;
	}

    /**
     * @return bool
     */
	public function __callBancoDoBrasil()
	{
		return $this->__authorize();
	}

    /**
     * @return bool
     * @throws OAuthException
     */
    private function __authorize()
    {
        try {
            $responseOauth = $this->httpClient->post($this->oAuthUrl, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic '.base64_encode($this->clientId . ':' . $this->clientSecret)
                ],
                'form_params' => [
                    'scope' => self::SCOPE,
                    'grant_type' => self::GRANT_TYPE
                ]
            ]);

            $oauth = json_decode($responseOauth->getBody());

            if ($oauth && !empty($oauth->access_token)) {
              	return $oauth;
            }
        } catch(\Exception $e) {
			throw new OAuthException();
        }

        throw new OAuthException();
    }
}
