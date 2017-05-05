<?php

namespace Vinala\Kernel\MVC\ORM\Exception;

/**
 * Directory not fount exception.
 */
class ColumnNotEmptyException extends \Exception
{
    public function __construct($column, $model)
    {
        $this->message = "Column $column already have value in $model model ";
    }
}
