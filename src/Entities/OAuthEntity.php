<?php 

namespace Ewersonfc\BBboleto\Entities;

/**
 * Class OAuthEntity
 * @package Ewersonfc\BBboleto\Entities
 */
class OAuthEntity
{
    /**
     * @var
     */

	private $typeToken;
    /**
     * @var
     */
	private $accessToken;

    /**
     * @var
     */
	private $environment;

    /**
     * @return mixed
     */
	public function getTypeToken()
	{
	    return $this->typeToken;
	}

    /**
     * @param $typeToken
     * @return $this
     */
	public function setTypeToken($typeToken)
	{
	    $this->typeToken = $typeToken;
	    return $this;
	}

    /**
     * @return mixed
     */
	public function getAccessToken()
	{
	    return $this->accessToken;
	}

    /**
     * @param $accessToken
     * @return $this
     */
	public function setAccessToken($accessToken)
	{
	    $this->accessToken = $accessToken;
	    return $this;
	}

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param $environment
     * @return $this
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

}