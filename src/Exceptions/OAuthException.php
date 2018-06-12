<?php 

namespace Ewersonfc\BBboleto\Exceptions;

use Throwable;

class OAuthException extends \Exception
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
            $message = 'Houve problema na comunicação';

        parent::__construct($message, $code, $previous);
    }
}
