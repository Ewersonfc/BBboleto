<?php namespace Ewersonfc\BBboleto\Entities;

use Ewersonfc\BBboleto\Constants\Juros;
use Ewersonfc\BBboleto\Helpers\BancoDoBrasil as BancoDoBrasilHelper;

/**
 * Class JurosEntity
 * @package Ewersonfc\BBboleto\Entities
 */
class JurosEntity
{
    /**
     * @var int
     */
	private $tipo = Juros::NAO_INFORMADO;

    /**
     * @var
     */
	private $percentual;

    /**
     * @var
     */
	private $valor;

    /**
     * @return int
     */
	public function getTipo()
	{
	    return $this->tipo;
	}

    /**
     * @param $tipo
     * @return $this
     */
	public function setTipo($tipo)
	{
	    $this->tipo = $tipo;
	    return $this;
	}

    /**
     * @return mixed
     */
	public function getPercentual()
	{
	    return $this->percentual;
	}

    /**
     * @param $percentual
     * @return $this
     */
	public function setPercentual($percentual)
	{
	    $this->percentual = $percentual;
	    return $this;
	}

    /**
     * @return mixed
     */
	public function getValor()
	{
	    return $this->valor;
	}

    /**
     * @param $valor
     * @return $this
     */
	public function setValor($valor)
	{
	    $this->valor = BancoDoBrasilHelper::formatMoney($valor);
	    return $this;
	}

}