<?php

namespace Vinala\Kernel\Config\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
 * Classv Aliased Not Found Exception.
 */
class AliasedClassNotFoundException extends Exception
{
    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------
    public function __construct($class, $array)
    {
        $this->message = "The class '$class' in '$array' aliases not found";
    }
}
