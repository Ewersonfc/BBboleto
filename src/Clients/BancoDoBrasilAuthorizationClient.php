<?php 

namespace Ewersonfc\BBboleto\Clients;


use GuzzleHttp\Client;
use Ewersonfc\BBboleto\Exceptions\OAuthException;

class BancoDoBrasilAuthorizationClient
{

	const OAUTH = 'https://oauth.hm.bb.com.br/oauth/token';

	const SCOPE = 'cobranca.registro-boletos';

	const GRANT_TYPE = 'client_credentials';

	/**
	*
	* @var Client
	*/

	private $httpClient;

	/**
	*
	* Constructor method
	* @param Client
	*/
	function __construct(array $config)
	{
		$this->httpClient = new Client();

		$this->clientId = array_get($config, 'clientId', null);
		$this->clientSecret = array_get($config, 'clientSecret', null);
		$this->oAuthUrl = array_get($config, 'production', false) == false? self::OAUTH : self::OAUTH;
	}

	public function __callBancoDoBrasil()
	{
		return $this->__authorize();
	}

	 /**
     * @return bool
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
