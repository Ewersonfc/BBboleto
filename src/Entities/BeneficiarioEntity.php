<?php namespace Ewersonfc\BBboleto\Entities;

class BeneficiarioEntity
{
	private $tipoDocumento;

	private $documento;

	private $nome;

	private $logradouro;

	private $cep;

	private $municipio;

	private $bairro;

	private $uf;

	private $telefone;

	public function getTipoDocumento()
	{
	    return $this->tipoDocumento;
	}
	 
	public function setTipoDocumento($tipoDocumento)
	{
	    $this->tipoDocumento = $tipoDocumento;
	    return $this;
	}

	public function getDocumento()
	{
	    return $this->documento;
	}
	 
	public function setDocumento($documento)
	{
	    $this->documento = $documento;
	    return $this;
	}

	public function getNome()
	{
	    return $this->nome;
	}
	 
	public function setNome($nome)
	{
	    $this->nome = $nome;
	    return $this;
	}

	public function getLogradouro()
	{
	    return $this->logradouro;
	}
	 
	public function setLogradouro($logradouro)
	{
	    $this->logradouro = $logradouro;
	    return $this;
	}

	public function getCep()
	{
	    return $this->cep;
	}
	 
	public function setCep($cep)
	{
	    $this->cep = $cep;
	    return $this;
	}

	public function getMunicipio()
	{
	    return $this->municipio;
	}
	 
	public function setMunicipio($municipio)
	{
	    $this->municipio = $municipio;
	    return $this;
	}

	public function getBairro()
	{
	    return $this->bairro;
	}
	 
	public function setBairro($bairro)
	{
	    $this->bairro = $bairro;
	    return $this;
	}

	public function getUf()
	{
	    return $this->uf;
	}
	 
	public function setUf($uf)
	{
	    $this->uf = $uf;
	    return $this;
	}

	public function getTelefone()
	{
	    return $this->telefone;
	}
	 
	public function setTelefone($telefone)
	{
	    $this->telefone = $telefone;
	    return $this;
	}
}
