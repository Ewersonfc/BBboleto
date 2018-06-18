<?php 

namespace Ewersonfc\BBboleto\Responses;

use Ewersonfc\BBboleto\Entities\PagadorEntity;

class BoletoResponse
{
	private $nossoNumero; 

	private $inicioNossoNumero;

	private $numeroDocumento;

	private $vencimento;

	private $emissao;

	private $processamento;

	private $valor;

	private $convenio;

	private $contrato;

	private $carteira;

	private $variacaoCarteira;

	private $especieTitulo;

	private $pagador; // Ewersonfc\BBboleto\Entities\PagadorEntity;

	private $demonstrativo;

	private $instrucoes;

	private $aceite;

	private $moeda = 'R$';

	private $agencia;

	private $conta;

	private $contaDigito;

	private $nomeBeneficiario;

	private $documento;

	private $endereco;

	private $cidade;

	private $uf;

	private $logo;

	public function getNossoNumero()
	{
	    return $this->nossoNumero;
	}
	 
	public function setNossoNumero($nossoNumero)
	{
	    $this->nossoNumero = $nossoNumero;
	    return $this;
	}

	public function getInicioNossoNumero()
	{
	    return $this->inicioNossoNumero;
	}
	 
	public function setInicioNossoNumero($inicioNossoNumero)
	{
	    $this->inicioNossoNumero = $inicioNossoNumero;
	    return $this;
	}

	public function getNumeroDocumento()
	{
	    return $this->numeroDocumento;
	}
	 
	public function setNumeroDocumento($numeroDocumento)
	{
	    $this->numeroDocumento = $numeroDocumento;
	    return $this;
	}

	public function getVencimento()
	{
	    return $this->vencimento;
	}
	 
	public function setVencimento($vencimento)
	{
	    $this->vencimento = $vencimento;
	    return $this;
	}

	public function getEmissao()
	{
	    return $this->emissao;
	}
	 
	public function setEmissao($emissao)
	{
	    $this->emissao = $emissao;
	    return $this;
	}


	public function getProcessamento()
	{
	    return $this->processamento;
	}
	 
	public function setProcessamento($processamento)
	{
	    $this->processamento = $processamento;
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

	public function getConvenio()
	{
	    return $this->convenio;
	}
	 
	public function setConvenio($convenio)
	{
	    $this->convenio = $convenio;
	    return $this;
	}

	public function getContrato()
	{
	    return $this->contrato;
	}
	 
	public function setContrato($contrato)
	{
	    $this->contrato = $contrato;
	    return $this;
	}

	public function getCarteira()
	{
	    return $this->carteira;
	}
	 
	public function setCarteira($carteira)
	{
	    $this->carteira = $carteira;
	    return $this;
	}

	public function getVariacaoCarteira()
	{
	    return $this->variacaoCarteira;
	}
	 
	public function setVariacaoCarteira($variacaoCarteira)
	{
	    $this->variacaoCarteira = $variacaoCarteira;
	    return $this;
	}

	public function getEspecieTitulo()
	{
	    return $this->especieTitulo;
	}
	 
	public function setEspecieTitulo($especieTitulo)
	{
	    $this->especieTitulo = $especieTitulo;
	    return $this;
	}

	public function getPagador()
	{
	    return $this->pagador;
	}
	 
	public function setPagador(PagadorEntity $pagador)
	{
	    $this->pagador = $pagador;
	    return $this;
	}

	public function getDemonstrativo()
	{
	    return $this->demonstrativo;
	}
	 
	public function setDemonstrativo($demonstrativo)
	{
	    $this->demonstrativo = $demonstrativo;
	    return $this;
	}

	public function getInstrucoes()
	{
	    return $this->instrucoes;
	}
	 
	public function setInstrucoes($instrucoes)
	{
	    $this->instrucoes = $instrucoes;
	    return $this;
	}

	public function getAceite()
	{
	    return $this->aceite;
	}
	 
	public function setAceite($aceite)
	{
	    $this->aceite = $aceite;
	    return $this;
	}

	public function getMoeda()
	{
	    return $this->moeda;
	}
	 
	public function setMoeda($moeda)
	{
	    $this->moeda = $moeda;
	    return $this;
	}

	public function getAgencia()
	{
	    return $this->agencia;
	}
	 
	public function setAgencia($agencia)
	{
	    $this->agencia = $agencia;
	    return $this;
	}

	public function getConta()
	{
	    return $this->conta;
	}
	 
	public function setConta($conta)
	{
	    $this->conta = $conta;
	    return $this;
	}

	public function getContaDigito()
	{
	    return $this->contaDigito;
	}
	 
	public function setContaDigito($contaDigito)
	{
	    $this->contaDigito = $contaDigito;
	    return $this;
	}

	public function getNomeBeneficiario()
	{
	    return $this->nomeBeneficiario;
	}
	 
	public function setNomeBeneficiario($nomeBeneficiario)
	{
	    $this->nomeBeneficiario = $nomeBeneficiario;
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

	public function getEndereco()
	{
	    return $this->endereco;
	}
	 
	public function setEndereco($endereco)
	{
	    $this->endereco = $endereco;
	    return $this;
	}

	public function getCidade()
	{
	    return $this->cidade;
	}
	 
	public function setCidade($cidade)
	{
	    $this->cidade = $cidade;
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

	public function getLogo()
	{
	    return $this->logo;
	}
	 
	public function setLogo($logo)
	{
	    $this->logo = $logo;
	    return $this;
	}
}



















