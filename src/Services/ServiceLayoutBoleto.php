<?php 

namespace Ewersonfc\BBboleto\Services;

use NovoBoletoPHP\BoletoFactory;
use mikehaertl\tmp\File;
use Ewersonfc\BBboleto\Helpers\BancoDoBrasil as BancoDoBrasilHelper;
use Ewersonfc\BBboleto\Responses\BoletoResponse;


class ServiceLayoutBoleto 
{
	private function makeBoleto(BoletoResponse $boletoResponse)
	{
		return [
			'convenio' => $boletoResponse->getConvenio(),
            'nosso_numero' => $boletoResponse->getNossoNumero(),
            'numero_documento' => $boletoResponse->getNossoNumero(),
            'data_vencimento' => $boletoResponse->getVencimento(),
            'data_documento' => $boletoResponse->getEmissao(),
            'data_processamento' => $boletoResponse->getProcessamento(),
            'valor_boleto' => number_format($boletoResponse->getValor(), 2, ',', ''),
            'carteira' => $boletoResponse->getCarteira(),
            'especie_doc' => $boletoResponse->getEspecieTitulo(),
            'sacado' => $boletoResponse->getPagador()->getNome(),
            'sacado_tipo_documento' => $boletoResponse->getPagador()->getTipoDocumento(),
            'sacado_documento' => $boletoResponse->getPagador()->getDocumento(),
            'endereco1' => $boletoResponse->getPagador()->getLogradouro().','.$boletoResponse->getPagador()->getBairro(),
            'endereco2' => $boletoResponse->getPagador()->getMunicipio().' - '.$boletoResponse->getPagador()->getUf().' - CEP '.$boletoResponse->getPagador()->getCep(),
            'demonstrativo1' => $boletoResponse->getDemonstrativo(),
            // 'instrucoes1' => array_shift($boleto['textoInformacaoClienteBeneficiario']),
            // 'instrucoes2' => array_shift($boleto['textoInformacaoClienteBeneficiario']),
            // 'instrucoes3' => array_shift($boleto['textoInformacaoClienteBeneficiario']),
            // 'instrucoes4' => implode(', ', $boleto['textoInformacaoClienteBeneficiario']),
            'aceite' => $boletoResponse->getAceite(),
            'especie' => $boletoResponse->getMoeda(),
            'agencia' => $boletoResponse->getAgencia(),
            'conta' => $boletoResponse->getConta(),
            'conta_dv' => '',
            'identificacao' => $boletoResponse->getNomeBeneficiario(),
            'cpf_cnpj' => BancoDoBrasilHelper::formatCnpj($boletoResponse->getDocumento()),
            'endereco' => $boletoResponse->getEndereco(),
            'cidade_uf' => $boletoResponse->getCidade().'-'.$boletoResponse->getUf(),
            'cedente' => $boletoResponse->getNomeBeneficiario(),
            'logo_empresa' => $logoEmpresa,
        ];

          
	}

	public function dataToHtml(BoletoResponse $boletoResponse)
	{
		$data = $this->makeBoleto($boletoResponse);

		try {
			$factory = new BoletoFactory([
	            'cachePath' => '/tmp',
	            'imageUrl' => realpath(dirname(__FILE__)."/../../resources/images")
	        ]);

          	$html = $factory->makeBoletoAsHTML(BoletoFactory::BANCO_DO_BRASIL, $data);
            $file = new File($html, '.html');
            $file->delete = false;

            return $file->getFileName();
        }catch(\Exception $e){
            return null;
        }
	}

	public function dataToPdf(BoletoResponse $boletoResponse)
	{

		$data = $this->makeBoleto($boletoResponse);

		try {
			$factory = new BoletoFactory([
	            'cachePath' => '/tmp',
	            'imageUrl' => realpath(dirname(__FILE__)."/../../resources/images")
	        ]);

	      	$pdf = $factory->makeBoletoAsPDF(BoletoFactory::BANCO_DO_BRASIL, $data);
            $file = new File($pdf, '.pdf');
            $file->delete = false;

            return $file->getFileName();
        }catch(\Exception $e){
            return null;
        }
	}
}