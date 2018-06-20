<?php 

namespace Ewersonfc\BBboleto\Exceptions;

use Throwable;

class BeneficiarioException extends \Exception
{
    /**
     * OAuthException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($message))
            $message = 'Beneficiario inválido';

        parent::__construct($message, $code, $previous);
    }
}
