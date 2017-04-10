<?php

namespace Vinala\Kernel\Http\Router\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
* Middleware not found exception
*/
class RouteNotFoundInRoutesRegisterException extends Exception
{

    function __construct($route)
    {
        $this->message = 'The route with the url '.$route->url.' not found in routes register.';
    }
}
