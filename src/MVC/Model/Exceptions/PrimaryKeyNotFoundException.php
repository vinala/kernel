<?php

namespace Vinala\Kernel\MVC\ORM\Exception;

/**
 * Directory not fount exception.
 */
class PrimaryKeyNotFoundException extends \Exception
{
    public function __construct($table)
    {
        $this->message = "Primary key not found in $table table ";
    }
}
