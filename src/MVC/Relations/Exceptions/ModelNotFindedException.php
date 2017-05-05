<?php

namespace Vinala\Kernel\MVC\Relations\Exception;

/**
 * Directory not fount exception.
 */
class ModelNotFindedException extends \Exception
{
    public function __construct($model)
    {
        $this->message = "The '$model' model not found";
    }
}
