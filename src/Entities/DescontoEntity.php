<?php 

namespace Ewersonfc\BBboleto\Entities;

use Ewersonfc\BBboleto\Constants\Desconto;

class DescontoEntity
{
	private $tipo = Desconto::SEM_DESCONTO;

	private $data;

	private $percentual;

	private $valor;

	private $valorAbatimento; // verificar

	public function getTipo()
	{
	    return $this->tipo;
	}
	 
	public function setTipo($tipo)
	{
	    $this->tipo = $tipo;
	    return $this;
	}

	public function getData()
	{
	    return $this->data;
	}
	 
	public function setData($data)
	{
	    $this->data = $data;
	    return $this;
	}

	public function getPercentual()
	{
	    return $this->percentual;
	}
	 
	public function setPercentual($percentual)
	{
	    $this->percentual = $percentual;
	    return $this;
	}

	public function getValor()
	{
	    return $this->valor;
	}
	 
	public function setValor($valor)
	{
	    $this->valor = $valor;
	    return $this;
	}

	public function getValorAbatimento()
	{
	    return $this->valorAbatimento;
	}
	 
	public function setValorAbatimento($valorAbatimento)
	{
	    $this->valorAbatimento = $valorAbatimento;
	    return $this;
	}
}

