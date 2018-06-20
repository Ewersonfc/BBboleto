<?php namespace Ewersonfc\BBboleto\Requests;

use Ewersonfc\BBboleto\Constants\AceiteTitulo;
use Ewersonfc\BBboleto\Constants\Modalidade;
use Ewersonfc\BBboleto\Constants\TipoTitulo;
use Ewersonfc\BBboleto\Constants\RecebimentoParcial;
use Ewersonfc\BBboleto\Entities\AvalistaEntity;
use Ewersonfc\BBboleto\Entities\BeneficiarioEntity;
use Ewersonfc\BBboleto\Entities\DescontoEntity;
use Ewersonfc\BBboleto\Entities\InstrucoesEntity;
use Ewersonfc\BBboleto\Entities\JurosEntity;
use Ewersonfc\BBboleto\Entities\MultaEntity;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Helpers\BancoDoBrasil as BancoDoBrasilHelper;

class BoletoRequest 
{
	private $convenio;

	private $carteira;

	private $variacaoCarteira;

	private $modalidade = Modalidade::SIMPLES; // Default 

	private $dataEmissao;

	private $dataVencimento;

	private $valorOriginal;

	private $desconto;

	private $diasProtesto = 0;

	private $juros;

	private $multa;

	private $aceite = AceiteTitulo::NAO_ACEITE;

	private $tipoTitulo = TipoTitulo::DUPLICATA_SERVICO;

	private $descricaoTipoTitulo;

	private $permissaoRecebimentoParcial = RecebimentoParcial::NAO;

	private $seuNumero; // = textoNumeroTITULOBeneficiario

	private $campoUtilizacaoBeneficiario;

	private $codigoTipoContaCaucao = 0;

	private $nossoNumero; // = textoNumeroTITULOBeneficiario

	private $instrucoes;

	private $pagador; 

	private $avalista;

	public function getConvenio()
	{
	    return $this->convenio;
	}
	 
	public function setConvenio($convenio)
	{
	    $this->convenio = $convenio;
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

	public function getModalidade()
	{
	    return $this->modalidade;
	}
	 
	public function setModalidade($modalidade)
	{
	    $this->modalidade = $modalidade;
	    return $this;
	}

	public function getDataEmissao()
	{
	    return $this->dataEmissao;
	}
	 
	public function setDataEmissao($dataEmissao)
	{
	    $this->dataEmissao = BancoDoBrasilHelper::generateDateTimeFromBoleto($dataEmissao);
	    return $this;
	}

	public function getDataVencimento()
	{
	    return $this->dataVencimento;
	}
	 
	public function setDataVencimento($dataVencimento)
	{
	    $this->dataVencimento = BancoDoBrasilHelper::generateDateTimeFromBoleto($dataVencimento);
	    return $this;
	}

	public function getValorOriginal()
	{
	    return $this->valorOriginal;
	}
	 
	public function setValorOriginal($valorOriginal)
	{
	    $this->valorOriginal = BancoDoBrasilHelper::formatMoney($valorOriginal);
	    return $this;
	}

	public function getDesconto()
	{
	    return $this->desconto;
	}
	 
	public function setDesconto(DescontoEntity $desconto)
	{
	    $this->desconto = $desconto;
	    return $this;
	}

	public function getDiasProtesto()
	{
	    return $this->diasProtesto;
	}
	 
	public function setDiasProtesto($diasProtesto)
	{
	    $this->diasProtesto = $diasProtesto;
	    return $this;
	}

	public function getJuros()
	{
	    return $this->juros;
	}
	 
	public function setJuros(JurosEntity $juros)
	{
	    $this->juros = $juros;
	    return $this;
	}

	public function getMulta()
	{
	    return $this->multa;
	}
	 
	public function setMulta(MultaEntity $multa)
	{
	    $this->multa = $multa;
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

	public function getTipoTitulo()
	{
	    return $this->tipoTitulo;
	}
	 
	public function setTipoTitulo($tipoTitulo)
	{
	    $this->tipoTitulo = $tipoTitulo;
	    return $this;
	}

	public function getDescricaoTipoTitulo()
	{
	    return $this->descricaoTipoTitulo;
	}
	 
	public function setDescricaoTipoTitulo($descricaoTipoTitulo)
	{
	    $this->descricaoTipoTitulo = $descricaoTipoTitulo;
	    return $this;
	}

	public function getPermissaoRecebimentoParcial()
	{
	    return $this->permissaoRecebimentoParcial;
	}
	 
	public function setPermissaoRecebimentoParcial($permissaoRecebimentoParcial)
	{
	    $this->permissaoRecebimentoParcial = $permissaoRecebimentoParcial;
	    return $this;
	}

	public function getSeuNumero()
	{
	    return $this->seuNumero;
	}
	 
	public function setSeuNumero($seuNumero)
	{
	    $this->seuNumero = $seuNumero;
	    return $this;
	}

	public function getCampoUtilizacaoBeneficiario()
	{
	    return $this->campoUtilizacaoBeneficiario;
	}
	 
	public function setCampoUtilizacaoBeneficiario($campoUtilizacaoBeneficiario)
	{
	    $this->campoUtilizacaoBeneficiario = $campoUtilizacaoBeneficiario;
	    return $this;
	}

	public function getCodigoTipoContaCaucao()
	{
	    return $this->codigoTipoContaCaucao;
	}
	 
	public function setCodigoTipoContaCaucao($codigoTipoContaCaucao)
	{
	    $this->codigoTipoContaCaucao = $codigoTipoContaCaucao;
	    return $this;
	}

	public function getNossoNumero()
	{
	    return $this->nossoNumero;
	}
	 
	public function setNossoNumero($nossoNumero)
	{
	    $this->nossoNumero = $nossoNumero;
	    return $this;
	}

	public function getInstrucoes()
	{
	    return $this->instrucoes;
	}
	 
	public function setInstrucoes(InstrucoesEntity $instrucoes)
	{
	    $this->instrucoes = $instrucoes;
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

	public function getAvalista()
	{
	    return $this->avalista;
	}
	 
	public function setAvalista(AvalistaEntity $avalista)
	{
	    $this->avalista = $avalista;
	    return $this;
	}

	public function getBeneficiario()
	{
	    return $this->beneficiario;
	}
	 
	public function setBeneficiario(BeneficiarioEntity $beneficiario)
	{
	    $this->beneficiario = $beneficiario;
	    return $this;
	}
}