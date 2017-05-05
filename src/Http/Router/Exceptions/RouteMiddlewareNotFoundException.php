<?php

namespace Vinala\Kernel\Http\Router\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
 * Middleware not found exception.
 */
class RouteMiddlewareNotFoundException extends Exception
{
    public function __construct($name)
    {
        $this->message = 'The middleware with the name '.$name.' not found in routes filter.';
    }
}
