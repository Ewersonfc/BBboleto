<?php 

namespace Ewersonfc\BBboleto\Services;

use Ewersonfc\BBboleto\Entities\OAuthEntity;
use Ewersonfc\BBboleto\Entities\DescontoEntity;
use Ewersonfc\BBboleto\Entities\JurosEntity;
use Ewersonfc\BBboleto\Entities\MultaEntity;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Exceptions\PagadorException;
use Ewersonfc\BBboleto\Requests\BoletoRequest;
use Ewersonfc\BBboleto\Soap\Clients\BoletoClient;
use Ewersonfc\BBboleto\Soap\Factories\BoletoFactory;


use GuzzleHttp\Client;
/**
*
*
*
*/
class ServiceRegister
{

	/**
	*
	* @var Ewersonfc\BBboleto\Soap\Factories\BoletoFactory
	*/
	private $boletoFactory;

	/**
	*
	* @param Ewersonfc\BBboleto\Soap\Factories\BoletoFactory
	*/ 
	function __construct()
	{
		$this->boletoFactory = new BoletoFactory;
	}

	/**
	*
	* @param Ewersonfc\BBboleto\Requests\BoletoRequest
	* @param Ewersonfc\BBboleto\Entities\OAuthEntity
	*/
	public function register(BoletoRequest $boletoRequest, OAuthEntity $oAuthEntity)
	{
		if(!$boletoRequest->getDesconto() instanceof DescontoEntity)
			$boletoRequest->setDesconto(new DescontoEntity());

		if(!$boletoRequest->getJuros() instanceof JurosEntity)
			$boletoRequest->setJuros(new JurosEntity());

		if(!$boletoRequest->getMulta() instanceof MultaEntity)
			$boletoRequest->setMulta(new MultaEntity());

		if(!$boletoRequest->getPagador() instanceof PagadorEntity)
			throw new PagadorException();

		$boletoBody = $this->boletoFactory->make($boletoRequest);

		$client = new Client([ 'verify' => false ]);
		$responseOauth = $client->post('https://cobranca.homologa.bb.com.br:7101/registrarBoleto', [
            'headers' => [
                'Content-Type' => 'text/xml',
                'Authorization' => 'Bearer '.base64_encode($oAuthEntity->getAccessToken()),
                'soapaction' => 'registrarBoleto'
            ],
            'query' => '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.tibco.com/schemas/bws_registro_cbr/Recursos/XSD/Schema.xsd">
						   <SOAP-ENV:Body>
						      <ns1:requisicao>
						         <ns1:numeroConvenio>1014051</ns1:numeroConvenio>
						         <ns1:numeroCarteira>17</ns1:numeroCarteira>
						         <ns1:numeroVariacaoCarteira>19</ns1:numeroVariacaoCarteira>
						         <ns1:codigoModalidadeTitulo>1</ns1:codigoModalidadeTitulo>
						         <ns1:dataEmissaoTitulo>01.03.2017</ns1:dataEmissaoTitulo>
						         <ns1:dataVencimentoTitulo>21.11.2017</ns1:dataVencimentoTitulo>
						         <ns1:valorOriginalTitulo>30000</ns1:valorOriginalTitulo>
						         <ns1:codigoTipoDesconto>1</ns1:codigoTipoDesconto>
						         <ns1:dataDescontoTitulo>21.11.2016</ns1:dataDescontoTitulo>
						         <ns1:percentualDescontoTitulo/>
						         <ns1:valorDescontoTitulo>10</ns1:valorDescontoTitulo>
						         <ns1:valorAbatimentoTitulo/>
						         <ns1:quantidadeDiaProtesto>0</ns1:quantidadeDiaProtesto>
						         <ns1:codigoTipoJuroMora>0</ns1:codigoTipoJuroMora>
						         <ns1:percentualJuroMoraTitulo/>
						         <ns1:valorJuroMoraTitulo/>
						         <ns1:codigoTipoMulta>2</ns1:codigoTipoMulta>
						         <ns1:dataMultaTitulo>22.11.2017</ns1:dataMultaTitulo>
						         <ns1:percentualMultaTitulo>10</ns1:percentualMultaTitulo>
						         <ns1:valorMultaTitulo/>
						         <ns1:codigoAceiteTitulo>N</ns1:codigoAceiteTitulo>
						         <ns1:codigoTipoTitulo>2</ns1:codigoTipoTitulo>
						         <ns1:textoDescricaoTipoTitulo>DUPLICATA</ns1:textoDescricaoTipoTitulo>
						         <ns1:indicadorPermissaoRecebimentoParcial>N</ns1:indicadorPermissaoRecebimentoParcial>
						         <ns1:textoNumeroTituloBeneficiario>987654321987654</ns1:textoNumeroTituloBeneficiario>
						         <ns1:textoCampoUtilizacaoBeneficiario/>
						         <ns1:codigoTipoContaCaucao>1</ns1:codigoTipoContaCaucao>
						         <ns1:textoNumeroTituloCliente>00010140510000000000</ns1:textoNumeroTituloCliente>
						         <ns1:textoMensagemBloquetoOcorrencia>Pagamento disponível até a data de vencimento</ns1:textoMensagemBloquetoOcorrencia>
						         <ns1:codigoTipoInscricaoPagador>2</ns1:codigoTipoInscricaoPagador>
						         <ns1:numeroInscricaoPagador>73400584000166</ns1:numeroInscricaoPagador>
						         <ns1:nomePagador>MERCADO ANDREAZA DE MACEDO</ns1:nomePagador>
						         <ns1:textoEnderecoPagador>RUA SEM NOME</ns1:textoEnderecoPagador>
						         <ns1:numeroCepPagador>12345678</ns1:numeroCepPagador>
						         <ns1:nomeMunicipioPagador>BRASILIA</ns1:nomeMunicipioPagador>
						         <ns1:nomeBairroPagador>SIA</ns1:nomeBairroPagador>
						         <ns1:siglaUfPagador>DF</ns1:siglaUfPagador>
						         <ns1:textoNumeroTelefonePagador>45619988</ns1:textoNumeroTelefonePagador>
						         <ns1:codigoTipoInscricaoAvalista/>
						         <ns1:numeroInscricaoAvalista/>
						         <ns1:nomeAvalistaTitulo/>
						         <ns1:codigoChaveUsuario>1</ns1:codigoChaveUsuario>
						         <ns1:codigoTipoCanalSolicitacao>5</ns1:codigoTipoCanalSolicitacao>
						      </ns1:requisicao>
						   </SOAP-ENV:Body>
						</SOAP-ENV:Envelope>'
        ]);
			
		dd($client->getBody());

	}
}