<?php

namespace Vinala\Kernel\Database\Schema\Exception;

/**
 * Directory not fount exception.
 */
class SchemaTableNotExistException extends \Exception
{
    public function __construct($table)
    {
        $this->message = "The table '$table' doesn't exist";
    }
}
