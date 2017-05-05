<?php

namespace Vinala\Kernel\Storage\Exception;

use Vinala\Kernel\Logging\Exception;

/**
 * Not Found Http Exception.
 */
class CookieKeyNotFoundException extends Exception
{
    public function __construct($key)
    {
        $this->message = 'The cookie variable '.$key.' not found';
        $this->view = config('error.regular');
    }
}
