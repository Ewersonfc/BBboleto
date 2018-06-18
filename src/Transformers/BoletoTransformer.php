<?php namespace Ewersonfc\BBboleto\Transformers;

use League\Fractal;

class BoletoTransformer extends Fractal\TransformerAbstract
{
	    /**
     * @param BoletoResponse $boleto
     * @return array
     */
    public function transform(BoletoResponse $boletoResponse)
    {
        return [
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
            'endereco' => $boletoResponse->setEndereco(),
            'cidade_uf' => $boletoResponse->getCidade().'-'.$boletoResponse->getUf(),
            'cedente' => $boletoResponse->getNomeBeneficiario(),
            // 'logo_empresa' => $logoEmpresa,
        ];
    }

}