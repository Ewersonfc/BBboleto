<?php namespace Ewersonfc\BBboleto\Transformers;

use League\Fractal;
use Ewersonfc\BBboleto\Services\ServiceLayoutBoleto;
use Ewersonfc\BBboleto\Helpers\BancoDoBrasil as BancoDoBrasilHelper;
use Ewersonfc\BBboleto\Responses\BoletoResponse;

class BoletoTransformer extends Fractal\TransformerAbstract
{   

    /**
    *
    * @var 
    */
    private $boleto;
	
    /**
    *
    * @param [array]
    * @param [string]
    */

    function __construct(array $config, string $boleto)
    {
        $this->boleto = $boleto;
        $this->cachePath = data_get($config,'cachePath', false);
    }

    /**
     *
     * @param BoletoResponse $boleto
     * @return array
     */
    public function transform(BoletoResponse $boletoResponse)
    {
        
        $instrucoes = $boletoResponse->getInstrucoes()->getInstrucoes();

        return [
            'id' => $boletoResponse->getNossoNumero(),
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
            'demonstrativo1' => $boletoResponse->getInstrucoes()->getDemonstrativo(),
            'instrucoes' => $instrucoes,
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
            'logo_empresa' => $boletoResponse->getLogo(),
            'arquivo' => $this->boleto
        ];
    }
}