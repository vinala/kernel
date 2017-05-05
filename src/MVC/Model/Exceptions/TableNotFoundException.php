<?php

namespace Vinala\Kernel\MVC\ORM\Exception;

/**
 * Directory not fount exception.
 */
class TableNotFoundException extends \Exception
{
    public function __construct($column)
    {
        $this->message = "'$column' table not found in the database";
    }
}
