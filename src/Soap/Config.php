<?php 

namespace Ewersonfc\BBboleto\Soap;

class Config
{
	const FUNCTION_DEFAULT = 'registrarBoleto';

	const WSDL = 'https://cobranca.homologa.bb.com.br:7101/registrarBoleto';

	const NAMESPACE = 'http://www.tibco.com/schemas/bws_registro_cbr/Recursos/XSD/Schema.xsd';

	const CHAVE_USUARIO = 1; 
}
