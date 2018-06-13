<?php namespace Ewersonfc\BBboleto\Entities;

class AvalistaEntity
{
	private $tipoDocumento;

	private $documento;

	private $nome;

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
}