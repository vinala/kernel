<?php

namespace Vinala\Kernel\Database\Connector\Exception;

use Vinala\Kernel\Logging\Exception;

/**
 * Directory not fount exception.
 */
class ConnectorException extends Exception
{
    public function __construct()
    {
        $this->message = 'We cannot connect to database';
        $this->view = config('error.database');
    }
}
