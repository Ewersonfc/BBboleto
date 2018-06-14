<?php namespace Ewersonfc\BBboleto\Soap\Factories;

use Cake\Utility\Xml;
use Ewersonfc\BBboleto\Entities\DescontoEntity;
use Ewersonfc\BBboleto\Entities\JurosEntity;
use Ewersonfc\BBboleto\Entities\MultaEntity;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Entities\AvalistaEntity;
use Ewersonfc\BBboleto\Exceptions\BoletoException;
use Ewersonfc\BBboleto\Requests\BoletoRequest;
use Ewersonfc\BBboleto\Constants\TipoCanal;


class BoletoFactory
{
	const CHAVE_USUARIO = 1;

	public function make(BoletoRequest $boletoRequest)
	{
		$data = [];

		$data['numeroConvenio'] = $boletoRequest->getConvenio();
		$data['numeroCarteira'] = $boletoRequest->getCarteira();
		$data['numeroVariacaoCarteira'] = $boletoRequest->getVariacaoCarteira();
		$data['codigoModalidadeTitulo'] = $boletoRequest->getModalidade();
		$data['dataEmissaoTitulo'] = $boletoRequest->getDataEmissao();
		$data['dataVencimentoTitulo'] = $boletoRequest->getDataVencimento();
		$data['valorOriginalTitulo'] = $boletoRequest->getValorOriginal();

		$data = $this->setDescontoOnBody($data, $boletoRequest->getDesconto());

		$data['quantidadeDiaProtesto'] = $boletoRequest->getDiasProtesto();

		$data = $this->setJurosOnBody($data, $boletoRequest->getJuros());

		$data = $this->setMultaOnBody($data, $boletoRequest->getMulta());

		$data['codigoAceiteTitulo'] = $boletoRequest->getAceite();
		$data['codigoTipoTitulo'] = $boletoRequest->getTipoTitulo();
		$data['textoDescricaoTipoTitulo'] = $boletoRequest->getDescricaoTipoTitulo();
		$data['indicadorPermissaoRecebimentoParcial'] = $boletoRequest->getPermissaoRecebimentoParcial();
		$data['textoNumeroTituloBeneficiario'] = $boletoRequest->getSeuNumero();
		$data['textoCampoUtilizacaoBeneficiario'] = $boletoRequest->getCampoUtilizacaoBeneficiario();
		$data['codigoTipoContaCaucao'] = $boletoRequest->getCodigoTipoContaCaucao();
		$data['textoNumeroTituloCliente'] = $boletoRequest->getNossoNumero();
		$data['textoMensagemBloquetoOcorrencia'] = $boletoRequest->getInstrucoes();
		
		$data = $this->setPagadorOnBody($data, $boletoRequest->getPagador());

		$data = $this->setAvalistaOnBody($data, $boletoRequest->getAvalista());

		$data['codigoChaveUsuario'] = self::CHAVE_USUARIO;
		$data['codigoTipoCanalSolicitacao'] = TipoCanal::IIB_WEBSERVICE; // default

		return $data;
	}

	/**
	*
	* Merge Array Desconto
	* @param array
	* @param Ewersonfc\BBboleto\Entities\DescontoEntity
	* @return array
	*/
	private function setDescontoOnBody(array $data, DescontoEntity $descontoEntity)
	{
		$dataDesconto = [];

		$dataDesconto['codigoTipoDesconto'] = $descontoEntity->getTipo();
		$dataDesconto['dataDescontoTitulo'] = $descontoEntity->getData();
		$dataDesconto['percentualDescontoTitulo'] = $descontoEntity->getPercentual();
		$dataDesconto['valorDescontoTitulo'] = $descontoEntity->getValor();
		$dataDesconto['valorAbatimentoTitulo'] = $descontoEntity->getValorAbatimento();

		return array_merge($data, $dataDesconto);
	}

	/**
	*
	* Merge Array Juros
	* @param array
	* @param Ewersonfc\BBboleto\Entities\JurosEntity
	* @return array
	*/
	private function setJurosOnBody(array $data, JurosEntity $jurosEntity)
	{
		$dataJuros = [];

		$dataJuros['codigoTipoJuroMora'] = $jurosEntity->getTipo();
		$dataJuros['percentualJuroMoraTitulo'] = $jurosEntity->getPercentual();
		$dataJuros['valorJuroMoraTitulo'] = $jurosEntity->getValor();

		return array_merge($data, $dataJuros);
	}

	/**
	*
	* Merge Array Multa
	* @param array
	* @param Ewersonfc\BBboleto\Entities\MultaEntity
	* @return array
	*/
	private function setMultaOnBody(array $data, MultaEntity $multaEntity)
	{
		$dataMulta = [];

		$dataMulta['codigoTipoMulta'] = $multaEntity->getTipo();
		$dataMulta['dataMultaTitulo'] = $multaEntity->getData();
		$dataMulta['percentualMultaTitulo'] = $multaEntity->getPercentual();
		$dataMulta['valorMultaTitulo'] = $multaEntity->getValor();

		return array_merge($data, $dataMulta);
	}

	/**
	*
	* Merge Pagador 
	* @param array
	* @param Ewersonfc\BBboleto\Entities\PagadorEntity
	* @return array 
	*/
	private function setPagadorOnBody(array $data, PagadorEntity $pagadorEntity)
	{
		$dataPagador = [];

		$dataPagador['codigoTipoInscricaoPagador'] = $pagadorEntity->getTipoDocumento();
		$dataPagador['numeroInscricaoPagador'] = $pagadorEntity->getDocumento();
		$dataPagador['nomePagador'] = $pagadorEntity->getNome();
		$dataPagador['textoEnderecoPagador'] = $pagadorEntity->getLogradouro();
		$dataPagador['numeroCepPagador'] = $pagadorEntity->getCep();
		$dataPagador['nomeMunicipioPagador'] = $pagadorEntity->getMunicipio();
		$dataPagador['nomeBairroPagador'] = $pagadorEntity->getBairro();
		$dataPagador['siglaUfPagador'] = $pagadorEntity->getUf();
		$dataPagador['textoNumeroTelefonePagador'] = $pagadorEntity->getTelefone();

		return array_merge($data, $dataPagador);
	}

	/**
	*
	* Merge Avalista 
	* @param array
	* @param Ewersonfc\BBboleto\Entities\AvalistaEntity
	* @return array 
	*/
	private function setAvalistaOnBody(array $data, AvalistaEntity $avalistaEntity)
	{
		$dataAvalista = [];

		$dataAvalista['codigoTipoInscricaoAvalista'] = $avalistaEntity->getTipoDocumento();
		$dataAvalista['numeroInscricaoAvalista'] = $avalistaEntity->getDocumento();
		$dataAvalista['nomeAvalistaTitulo'] = $avalistaEntity->getNome();

		return array_merge($data, $dataAvalista);
	}
}