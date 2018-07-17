<?php namespace Ewersonfc\BBboleto\Soap\Factories;

use SoapVar;
use Ewersonfc\BBboleto\Entities\DescontoEntity;
use Ewersonfc\BBboleto\Entities\JurosEntity;
use Ewersonfc\BBboleto\Entities\MultaEntity;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Entities\AvalistaEntity;
use Ewersonfc\BBboleto\Helpers\BancoDoBrasil as BancoDoBrasilHelper;
use Ewersonfc\BBboleto\Requests\BoletoRequest;
use Ewersonfc\BBboleto\Constants\TipoCanal;
use Ewersonfc\BBboleto\Soap\Config;

/**
 * Class BoletoFactory
 * @package Ewersonfc\BBboleto\Soap\Factories
 */
class BoletoFactory
{
    /**
     * @param BoletoRequest $boletoRequest
     * @return array
     */
	public function make(BoletoRequest $boletoRequest)
	{
		$data = [];

		$data[] = new SoapVar((int) $boletoRequest->getConvenio(), XSD_INT, null, null, 'numeroConvenio', Config::NAMESPACE);
		$data[] = new SoapVar((int) $boletoRequest->getCarteira(), XSD_INT, null, null, 'numeroCarteira', Config::NAMESPACE);
		$data[] = new SoapVar((int) $boletoRequest->getVariacaoCarteira(), XSD_INT, null, null, 'numeroVariacaoCarteira', Config::NAMESPACE);
		$data[] = new SoapVar($boletoRequest->getModalidade(), XSD_INT, null, null, 'codigoModalidadeTitulo', Config::NAMESPACE);
		$data[] = new SoapVar($boletoRequest->getDataEmissao()->format('d.m.Y'), XSD_DATE, null, null, 'dataEmissaoTitulo', Config::NAMESPACE);
		$data[] = new SoapVar($boletoRequest->getDataVencimento()->format('d.m.Y'), XSD_DATE, null, null, 'dataVencimentoTitulo', Config::NAMESPACE);
		$data[] = new SoapVar(BancoDoBrasilHelper::formatMoney($boletoRequest->getValorOriginal()), XSD_STRING, null, null, 'valorOriginalTitulo', Config::NAMESPACE);

		if($boletoRequest->getDesconto() instanceof DescontoEntity) 
			$data = $this->setDescontoOnBody($data, $boletoRequest->getDesconto());	

		$data[] = new SoapVar($boletoRequest->getDiasProtesto(), XSD_INT, null, null, 'quantidadeDiaProtesto', Config::NAMESPACE);

		if($boletoRequest->getJuros() instanceof JurosEntity)
			$data = $this->setJurosOnBody($data, $boletoRequest->getJuros());

		if($boletoRequest->getMulta() instanceof MultaEntity)
			$data = $this->setMultaOnBody($data, $boletoRequest->getMulta());

		$data[] = new SoapVar($boletoRequest->getAceite(), XSD_STRING, null, null, 'codigoAceiteTitulo', Config::NAMESPACE);
		$data[] = new SoapVar($boletoRequest->getTipoTitulo(), XSD_STRING, null, null, 'codigoTipoTitulo', Config::NAMESPACE);
		$data[] = new SoapVar($boletoRequest->getDescricaoTipoTitulo(), XSD_STRING, null, null, 'textoDescricaoTipoTitulo', Config::NAMESPACE);
		$data[] = new SoapVar($boletoRequest->getPermissaoRecebimentoParcial(), XSD_STRING, null, null, 'indicadorPermissaoRecebimentoParcial', Config::NAMESPACE);
		$data[] = new SoapVar($boletoRequest->getSeuNumero(), XSD_INT, null, null, 'textoNumeroTituloBeneficiario', Config::NAMESPACE);
		$data[] = new SoapVar(BancoDoBrasilHelper::chacracterLimit($boletoRequest->getCampoUtilizacaoBeneficiario(), 25), XSD_STRING, null, null, 'textoCampoUtilizacaoBeneficiario', Config::NAMESPACE);
		$data[] = new SoapVar($boletoRequest->getCodigoTipoContaCaucao(), XSD_INT, null, null, 'codigoTipoContaCaucao', Config::NAMESPACE);	
		$data[] = new SoapVar(BancoDoBrasilHelper::makeNossoNumero($boletoRequest->getConvenio(), $boletoRequest->getNossoNumero()), XSD_STRING, null, null, 'textoNumeroTituloCliente', Config::NAMESPACE);
		$data[] = new SoapVar(BancoDoBrasilHelper::chacracterLimit(implode(' - ', $boletoRequest->getInstrucoes()->getInstrucoes()), 220), XSD_STRING, null, null, 'textoMensagemBloquetoOcorrencia', Config::NAMESPACE);
		
		if($boletoRequest->getPagador() instanceof PagadorEntity)
			$data = $this->setPagadorOnBody($data, $boletoRequest->getPagador());
		if($boletoRequest->getAvalista() instanceof AvalistaEntity)
			$data = $this->setAvalistaOnBody($data, $boletoRequest->getAvalista());

		$data[] = new SoapVar(Config::CHAVE_USUARIO, XSD_INT, null, null, 'codigoChaveUsuario', Config::NAMESPACE);
		$data[] = new SoapVar(TipoCanal::IIB_WEBSERVICE, XSD_STRING, null, null, 'codigoTipoCanalSolicitacao', Config::NAMESPACE);

		return $data;
	}

    /**
     * @param array $data
     * @param DescontoEntity $descontoEntity
     * @return array
     */
	private function setDescontoOnBody(array $data, DescontoEntity $descontoEntity)
	{
		$dataDesconto = [];

		$dataDesconto[] = new SoapVar($descontoEntity->getTipo(), XSD_INT, null, null, 'codigoTipoDesconto', Config::NAMESPACE);
		$dataDesconto[] = new SoapVar($descontoEntity->getData()->format('d.m.Y'), XSD_DATE, null, null, 'dataDescontoTitulo', Config::NAMESPACE);
		$dataDesconto[] = new SoapVar($descontoEntity->getPercentual(), XSD_STRING, null, null, 'percentualDescontoTitulo', Config::NAMESPACE);
		$dataDesconto[] = new SoapVar(BancoDoBrasilHelper::formatMoney($descontoEntity->getValor()), XSD_STRING, null, null, 'valorDescontoTitulo', Config::NAMESPACE);
		$dataDesconto[] = new SoapVar(BancoDoBrasilHelper::formatMoney($descontoEntity->getValorAbatimento()), XSD_STRING, null, null, 'valorAbatimentoTitulo', Config::NAMESPACE);

		return array_merge($data, $dataDesconto);
	}

    /**
     * @param array $data
     * @param JurosEntity $jurosEntity
     * @return array
     */
	private function setJurosOnBody(array $data, JurosEntity $jurosEntity)
	{
		$dataJuros = [];

		$dataJuros[] = new SoapVar($jurosEntity->getTipo(), XSD_INT, null, null, 'codigoTipoJuroMora', Config::NAMESPACE);
		$dataJuros[] = new SoapVar($jurosEntity->getPercentual(), XSD_STRING, null, null, 'percentualJuroMoraTitulo', Config::NAMESPACE);
		$dataJuros[] = new SoapVar(BancoDoBrasilHelper::formatMoney($jurosEntity->getValor()), XSD_STRING, null, null, 'valorJuroMoraTitulo', Config::NAMESPACE);

		return array_merge($data, $dataJuros);
	}

    /**
     * @param array $data
     * @param MultaEntity $multaEntity
     * @return array
     */
	private function setMultaOnBody(array $data, MultaEntity $multaEntity)
	{
		$dataMulta = [];

		$dataMulta[] = new SoapVar($multaEntity->getTipo(), XSD_INT, null, null, 'codigoTipoMulta', Config::NAMESPACE);
		$dataMulta[] = new SoapVar($multaEntity->getData()->format('d.m.Y'), XSD_DATE, null, null, 'dataMultaTitulo', Config::NAMESPACE);
		$dataMulta[] = new SoapVar($multaEntity->getPercentual(), XSD_STRING, null, null, 'percentualMultaTitulo', Config::NAMESPACE);
		$dataMulta[] = new SoapVar(BancoDoBrasilHelper::formatMoney($multaEntity->getValor()), XSD_STRING, null, null, 'valorMultaTitulo', Config::NAMESPACE);

		return array_merge($data, $dataMulta);
	}

    /**
     * @param array $data
     * @param PagadorEntity $pagadorEntity
     * @return array
     */
	private function setPagadorOnBody(array $data, PagadorEntity $pagadorEntity)
	{
		$dataPagador = [];

		$dataPagador[] = new SoapVar($pagadorEntity->getTipoDocumento(), XSD_INT, null, null, 'codigoTipoInscricaoPagador', Config::NAMESPACE);
		$dataPagador[] = new SoapVar(BancoDoBrasilHelper::numbers($pagadorEntity->getDocumento()), XSD_STRING, null, null, 'numeroInscricaoPagador', Config::NAMESPACE);
		$dataPagador[] = new SoapVar($pagadorEntity->getNome(), XSD_STRING, null, null, 'nomePagador', Config::NAMESPACE);
		$dataPagador[] = new SoapVar($pagadorEntity->getLogradouro(), XSD_STRING, null, null, 'textoEnderecoPagador', Config::NAMESPACE);
		$dataPagador[] = new SoapVar(BancoDoBrasilHelper::numbers($pagadorEntity->getCep()), XSD_STRING, null, null, 'numeroCepPagador', Config::NAMESPACE);
		$dataPagador[] = new SoapVar($pagadorEntity->getMunicipio(), XSD_STRING, null, null, 'nomeMunicipioPagador', Config::NAMESPACE);
		$dataPagador[] = new SoapVar($pagadorEntity->getBairro(), XSD_STRING, null, null, 'nomeBairroPagador', Config::NAMESPACE);
		$dataPagador[] = new SoapVar($pagadorEntity->getUf(), XSD_STRING, null, null, 'siglaUfPagador', Config::NAMESPACE);
		$dataPagador[] = new SoapVar(BancoDoBrasilHelper::numbers($pagadorEntity->getTelefone()), XSD_STRING, null, null, 'textoNumeroTelefonePagador', Config::NAMESPACE);

		return array_merge($data, $dataPagador);
	}

    /**
     * @param array $data
     * @param AvalistaEntity $avalistaEntity
     * @return array
     */
	private function setAvalistaOnBody(array $data, AvalistaEntity $avalistaEntity)
	{
		$dataAvalista = [];

		$dataAvalista[] = new SoapVar($avalistaEntity->getTipoDocumento(), XSD_INT, null, null, 'codigoTipoInscricaoAvalista', Config::NAMESPACE);
		$dataAvalista[] = new SoapVar($avalistaEntity->getDocumento(), XSD_STRING, null, null, 'numeroInscricaoAvalista', Config::NAMESPACE);
		$dataAvalista[] = new SoapVar($avalistaEntity->getNome(), XSD_STRING, null, null, 'nomeAvalistaTitulo', Config::NAMESPACE);

		return array_merge($data, $dataAvalista);
	}
}