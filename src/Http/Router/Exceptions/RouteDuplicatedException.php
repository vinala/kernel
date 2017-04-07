<?php

namespace Vinala\Kernel\Http\Router\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
* Middleware not found exception
*/
class RouteDuplicatedException extends Exception
{

    function __construct($route)
    {
        $this->message = 'The route with the url '.$route->url.' is duplicated.';
    }
}
