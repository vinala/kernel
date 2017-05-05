<?php

namespace Vinala\Kernel\MVC\Relations\Exception;

/**
 * Directory not fount exception.
 */
class ManyRelationException extends \Exception
{
    public function __construct($localModel, $remoteModel)
    {
        $this->message = "The $localModel and $remoteModel have more then one relation";
    }
}
