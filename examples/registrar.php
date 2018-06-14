<?php
/**
 * Created by PhpStorm.
 * User: Ewerson
 * Date: 18/04/18
 * Time: 11:07
 */

require 'vendor/autoload.php';

use Ewersonfc\BBboleto\BancoDoBrasil;
use Ewersonfc\BBboleto\Constants\AceiteTitulo;
use Ewersonfc\BBboleto\Constants\Desconto;
use Ewersonfc\BBboleto\Constants\Juros;
use Ewersonfc\BBboleto\Constants\TipoDocumento;
use Ewersonfc\BBboleto\Constants\TipoTitulo;
use Ewersonfc\BBboleto\Constants\Modalidade;
use Ewersonfc\BBboleto\Constants\Multa;
use Ewersonfc\BBboleto\Constants\RecebimentoParcial;
use Ewersonfc\BBboleto\Entities\AvalistaEntity;
use Ewersonfc\BBboleto\Entities\DescontoEntity;
use Ewersonfc\BBboleto\Entities\JurosEntity;
use Ewersonfc\BBboleto\Entities\MultaEntity;
use Ewersonfc\BBboleto\Entities\PagadorEntity;
use Ewersonfc\BBboleto\Requests\BoletoRequest;

$bancoDoBrasil = new BancoDoBrasil([
	'clientId' => 'eyJpZCI6IjgwNDNiNTMtZjQ5Mi00YyIsImNvZGlnb1B1YmxpY2Fkb3IiOjEwOSwiY29kaWdvU29mdHdhcmUiOjEsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxfQ',
	'clientSecret' => 'eyJpZCI6IjBjZDFlMGQtN2UyNC00MGQyLWI0YSIsImNvZGlnb1B1YmxpY2Fkb3IiOjEwOSwiY29kaWdvU29mdHdhcmUiOjEsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MX0',
	'production' => false
]);

// Nota: O desconto é opcional, caso não tenha desconto no título não há necessiade de preencher esta entidade e tbm não há necessidade de setar no Request
$desconto = new DescontoEntity;
$desconto->setTipo(Desconto::VALOR) // [Tipo: inteiro| Opcional |Valor: Só serão aceitos os valores 0, 1, 2 ou 3 como descrito acima PRESENTES NA ARQUIVO (Contants\Desconto.php)]
	->setData('10/07/2018') // [Tipo: string | Informar somente se “TIPO DE DESCONTO” igual a \Desconto::VALOR\ ou \Desconto::POR_DIA_DE_ANTECIPACAO\ ]
	// ->setPercentual() // [Tipo: inteiro | informar somente se “TIPO DE DESCONTO” igual a \Desconto::PERCENTUAL\ ]
	->setValor('5.00'); // [Tipo: numeric | Informar somente se “TIPO DE DESCONTO” igual a \Desconto::VALOR\ ou \Desconto::POR_DIA_DE_ANTECIPACAO\ | Menor que valor do título ]
	// ->setValorAbatimento(); // [Tipo: numeric | Se informado, somado ao "setValor()" tem que ser menor que valor do título ]

// Nota: O Juros é opcional, caso não tenha desconto no título não há necessiade de preencher esta entidade e tbm não há necessidade de setar no Request
$juros = new JurosEntity;
$juros->setTipo(Juros::VALOR_POR_DIA_DE_ATRASO)// [Tipo: inteiro| Opcional |  Valor: Só serão aceitos os valores 0, 1, 2 ou 3 como descrito acima PRESENTES NA ARQUIVO (Contants\Juros.php)]
	->setPercentual('99999,99'); // [Tipo: numeric | Opcional/Condicional | O percentual de desconto quando informado não pode ser maior do que 100% e o campo “setValor()” deve ser igual a ‘0’ (zero) ]
	// ->setValor(); // [Tipo: inteiro| Opcional/Condicional | Se informado, "->setPercentual()" deve ser ‘0’ (zero) e valor menor que "VALOR ORIGINAL DO TÍTULO" ]

// // Nota: O Multa é opcional, caso não tenha desconto no título não há necessiade de preencher esta entidade e tbm não há necessidade de setar no Request
// $multa = new MultaEntity;
// $multa->setTipo(Multa::A_PARTIR_DATA)
// 	->setData('18/08/2018') // [Tipo: date | Obrigatorio/Condicional | Se informado Multa::A_PARTIR_DATA e não pode ser maior que a “DATA DE VENCIMENTO DO TÍTULO” ]
// 	->setPercentual('99999,99'); // [Tipo: numeric | Opcional | O percentual de desconto, quando informado, não pode ser maior do que 100% e o campo “VALOR DA MULTA DO TÍTULO” deve ser igual a ‘0’ (zero)]
// 	// ->setValor(); // [Tipo: numeric | Opcional | O percentual de desconto, quando informado, não pode ser maior do que 100% e o campo “VALOR DA MULTA DO TÍTULO” deve ser igual a ‘0’ (zero)]

$pagador = new PagadorEntity;
$pagador->setTipoDocumento(TipoDocumento::CNPJ) // [Campo Opcional] Se informado só serão aceitos os valores ‘1’ ou ‘2’ como descrito no domínio. PRESENTES NA ARQUIVO (Contants\TipoDocumento.php)
	->setDocumento('09.127.271/0001-87') //[Campo Opcional]
	->setNome('E-htl Viagens On-line') //[Campo Opcional]
	->setLogradouro('Avenida Ipiranga, n° 104') //[Campo Opcional]
	->setCep('01046-010') // [Campo Opcional]
	->setMunicipio('São Paulo') // [Campo Opcional]
	->setBairro('República') // [Campo Opcional]
	->setUf('SP') // [Campo Opcional]
	->setTelefone('11 3136-5858'); // [Campo Opcional]

// Nota: O Avalista é opcional, caso não tenha desconto no título não há necessiade de preencher esta entidade e tbm não há necessidade de setar no Request
$avalista = new AvalistaEntity;
$avalista->setTipoDocumento(TipoDocumento::CNPJ)//[Campo Opcional] Se informado só serão aceitos os valores ‘1’ ou ‘2’ como descrito no domínio. PRESENTES NA ARQUIVO (Contants\TipoDocumento.php)
	->setDocumento('09.123.123\0001-81') // Documento do do Avalista
	->setNome('Ewerson Carvalho'); // Nome do Avalista


$boletoRequest = new BoletoRequest();
$boletoRequest->setConvenio('9999999') // [Tipo: inteiro| Obrigatório |Valor: permitidos valores de 1.000.000 até 9.999.999]
	->setCarteira('17') // [Tipo: inteiro| Obrigatório |Valor: Somente permitido a carteira 17]
	->setVariacaoCarteira('1') // [Tipo: inteiro| Obrigatório |Valor: numérico maior que zeros]
	->setModalidade(Modalidade::SIMPLES) // [Tipo: inteiro| Obrigatório |Valor: possíveis de aceitação os números 1, 4, 6 e 8 PRESENTES NA ARQUIVO (Contants\Modalidade.php)]
	->setDataEmissao('05/07/2018') // ['Tipo: string| Obrigatório | Data Válida |Não pode ser maior que a data atual, anterior que 365 dias ou maior que a data de vencimento do título']
	->setDataVencimento('15/07/2018') // ['Tipo: string| Obrigatório | Data Válida |Não pode ser maior que a data atual, anterior que 365 dias ou maior que a data de vencimento do título']
	->setValorOriginal('17.20') // ['Tipo: numeric| Obrigatório | Tem que ser maior que a soma dos campos “VALOR DO DESCONTO DO TÍTULO” e “VALOR DO ABATIMENTO DO TÍTULO” informados]
	->setDesconto($desconto) // [Tipo: class| Opcional | Preencher a entidade desconto como demostrado acima, caso não tenha desconto não há necessidade de setar esse valor] 
	->setDiasProtesto('2') // [Tipo: inteiro | Opcional | define o número de dias decorrentes, após a data de vencimento, para inicialização do processo de cobrança, via protesto, do Título de Cobrança.]
	//Se informado, só será aceito se a combinação dos campos "setModalidade()" e “setTipoTitulo()” forem compatíveis com a possibilidade de protesto
	->setJuros($juros)
	// ->setMulta($multa)
	->setAceite(AceiteTitulo::ACEITE) // [Tipo: string | Obrigatório | Só serão aceitos os valores ‘AceiteTitulo::ACEITE’ ou ‘AceiteTitulo::NAO_ACEITE’ como descrito no domínio.]
	->setTipoTitulo(TipoTitulo::DUPLICATA_SERVICO) // [Tipo: string | Opcional | Se não informado irá assumir TipoTitulo::DUPLICATA_SERVICO]
	->setDescricaoTipoTitulo("Texto livre") // [Tipo: string | Opcional | Campo de texto livre]
	->setPermissaoRecebimentoParcial(RecebimentoParcial::NAO) // [Tipo: bool | Opcional | Se não informado irá assumir RecebimentoParcial::NAO ]
	->setSeuNumero('1948484')// [Tipo: string | Opcional |  Não permite caracteres especiais ]
	->setCampoUtilizacaoBeneficiario('0000000') // [Tipo: string | Opcional | 25 posições | Não permite caracteres especiais ]
	->setCodigoTipoContaCaucao('0') // [Tipo: string | Opcional | 25 posições | Se não preenchido assumirá 0 ]
	->setNossoNumero('99999999999') // [Tipo: inteiro | Obrigatório | Preencher somente com o valor de controle do nosso numero ]
	->setInstrucoes("instrução") // [Tipo: inteiro | opcional | − Não permite caracteres especiais]
	->setPagador($pagador) // [Tipo: PagadorEntity]
	->setAvalista($avalista);


$bancoDoBrasil->register($boletoRequest);
