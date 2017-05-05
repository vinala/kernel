<?php

namespace Vinala\Kernel\Setup\Exception;

use Vinala\Kernel\Logging\Exception;

/**
 * Directory not fount exception.
 */
class AppSetupException extends Exception
{
    protected $message;

    //
    public function __construct()
    {
        $this->message = 'The app is not yet setted up, visit the home page or set true in setup parameter in app config file';
    }
}
