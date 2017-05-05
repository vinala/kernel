<?php

namespace Vinala\Kernel\MVC\ORM\Exception;

/**
 * Directory not fount exception.
 */
class ModelNotFoundException extends \Exception
{
    public function __construct($id, $model)
    {
        $this->message = "The model '$model' with the id of $id not found";
    }
}
