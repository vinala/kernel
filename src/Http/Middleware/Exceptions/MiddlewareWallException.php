<?php

namespace Vinala\Kernel\Http\Middleware\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
 * Middleware breaks exception.
 */
class MiddlewareWallException extends Exception
{
    public function __construct($middleware)
    {
        $this->message = 'The middleware '.$middleware.' result are not granted.';
        $this->view = config('error.regular');
    }
}
