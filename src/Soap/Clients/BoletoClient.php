<?php 

namespace Ewersonfc\BBboleto\Soap\Clients;

use SoapClient;

class BoletoClient extends SoapClient
{

	const FUNCTION_DEFAULT = 'registrarBoleto';

	const WSDL = 'https://cobranca.homologa.bb.com.br:7101/Processos/Ws/RegistroCobrancaService.serviceagent?wsdl';

	const NAMESPACE = 'http://www.tibco.com/schemas/bws_registro_cbr/Recursos/XSD/Schema.xsd';

	/**
	*
	* @var SoapClient
	*/ 
	private $client;

	/**
	*
	* Constructor Method
	*/
	function __construct()
	{
		parent::__construct(null, [
			'Authorization' => "Bearer PR0UEBbLWRmVt72edDFvybQOQpXUQnqOBqNveSSMfl2HgYRk-d6yzOWpc54rwKvi6JQG6w9ycw-4QT7nE_jtYw.L_O92qbMaqvmLqW9JFFzexmMDDA5eVM7oOlbtkeRjJQH4U1L8rE49Kf-gu2w-WpxpRRtCFzAsL9GimvCmatNnVgER3Hz-Xnn3J-00Ib7TCBoIQnmj2aAoK9mNWj7cvcGXu7QMDMwbtYTrBeUmX2I6Vk0wTAhFxqjBz5TlcqLu69bUOjEQp5q7t465pl9n7SCX4kWz6W8FBWXArqv15RPDUatuBvQosxZPCV4UGrAThbUEeMptFBOWxpY3QAeSYetEuwJJsRo6HbR0o_Covt7ZwqItpLF2umIvHdDSVL3WwxJOCqsTksb_4aR66wyyAu2mSjoQL5Hz-F9Ay4qFFe5Td2r2G_CQetpdeJjyeL3aQPKFDwx8NB-mrY1vGKc3cF8231v4NNdYa6GgdDOYw5l1DFTjBGCEKRfmIXk1aU05_5gBaeunGFkdJu2QXu1TJTvBVwngfJX-PPeVsR1mGezlZ0L_A7xwaN7sGkjozAJmQbFBr8CkY1lkV6hDECPcnNDVlfwk2ZV1R8iuON0O-9DBwC_6QdeLP8Uq74TzCyUVbqHOzGxpOH8SCJ8h3kOwCo03WLeTMulLPVx-beaHw4bN0FtsEhCgNewaNFPit6Hn9dpcV28QXhdA2Mp6cIslRNiBWt5pxoEp6wt3-x4HJ6MFQ.GraYRvAvhiA-gg5CBJ1OSCSnh6owldFmXLpEf-vf9NgVVGyfDusXPfLlk2lrV7NMHUjyQIMzQt7c5NtKZ5DOmw",
			'exceptions' => 1,
            'location' => str_replace("?wsdl","", self::WSDL),
    		'trace' => 1,
            'uri' => self::NAMESPACE,
    		'connection_timeout' => 1800,
    		'soap_version' => SOAP_1_1,
    		'use' => SOAP_LITERAL,
    		'compression' =>  SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
    		'soapaction' => 'registrarBoleto',
    		'stream_context' => stream_context_create(
							array(
								'https' => array(
									'curl_verify_ssl_peer' => false,
									'curl_verify_ssl_host' => false
								),
								'ssl' => array(
									'verify_peer' => false,
									'allow_self_signed' => true
								),
								// 'sslv3' => array(
								// 	'verify_peer' => false,
								// 	'allow_self_signed' => true
								// )
							)
						)
		]);
	}
}