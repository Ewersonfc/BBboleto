<?php 

namespace Ewersonfc\BBboleto\Entities;

class OAuthEntity
{
	private $typeToken; 

	private $accessToken;

	public function getTypeToken()
	{
	    return $this->typeToken;
	}
	 
	public function setTypeToken($typeToken)
	{
	    $this->typeToken = $typeToken;
	    return $this;
	}

	public function getAccessToken()
	{
	    return $this->accessToken;
	}
	 
	public function setAccessToken($accessToken)
	{
	    $this->accessToken = $accessToken;
	    return $this;
	}

}