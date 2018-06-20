<?php 

namespace Ewersonfc\BBboleto\Helpers;

use Carbon\Carbon;
use Ewersonfc\BBboleto\Exceptions\BoletoException;

class BancoDoBrasil
{
 	/**
     * @param $cnpj
     * @return string
     */
    public static function formatCnpj($cnpj) {
        $cnpj = trim($cnpj);
        if(preg_match('/^[0-9]+$/', $cnpj)) {
            $aux = str_split($cnpj);
            array_splice($aux, 2, 0, '.');
            array_splice($aux, 6, 0, '.');
            array_splice($aux, 10, 0, '/');
            array_splice($aux, 15, 0, '-');
            return implode('', $aux);
        }

        return $cnpj;
    }

   	/**
	 * @param $string
	 * @return string
	 */
    public static function numbers($str)
	{
		return preg_replace("/[^0-9]/", "", $str);
	}

	 /**
     * @param $value
     * @param int $amount
     * @return string
     */
    public static function formatMoney($value, $amount = 1)
    {
        if(!$value)
            return null;
        
        $moneyExplode = explode(',', $value);       
        if(count($moneyExplode)> 1) {
            $money = str_replace('.', '', $value);
            $money = str_replace(',', '.', $money);

            return $money;
        } else {
            return number_format($value, 2, '.', '');
        }
    }

    public static function formatDecimal($value, $amount = 1, $decimal = 2)
    {
        $money = str_replace(',', '', $value);
        $money = str_replace('.', '', $money);
        $money = str_pad($money, $amount, '0', STR_PAD_LEFT);
        $money = str_pad($money, $decimal, '0', STR_PAD_RIGHT);

        return $money;
    }

    public static function chacracterLimit($string, $limit)
    {
    	return mb_substr($string, 0, $limit, 'utf8');
    }

    public static function makeNossoNumero($convenio, $nossoNumero)
    {
    	if(strlen($nossoNumero) < 10)
    		$nossoNumero = str_pad($nossoNumero, 10, '0', STR_PAD_LEFT);

    	return str_pad(($convenio.$nossoNumero), 20, '0', STR_PAD_LEFT);
    }

    public static function generateDateTimeFromBoleto($date)
    {
    	$formats = [
    		'd/m/Y',
    		'Y-m-d'
    	];
    	$dateOfCarbon = false;

    	foreach ($formats as $format) {
    		try
    		{
    			$dateOfCarbon = Carbon::createFromFormat($format, $date);
    		} catch(\InvalidArgumentException $e) {
    			continue;
    		}
    	}

    	if(!$dateOfCarbon)
	    	throw new BoletoException('Formato de Data Inválidos. Formato Suportados: d/m/Y e Y-m-d');

	    return $dateOfCarbon;
    }
}