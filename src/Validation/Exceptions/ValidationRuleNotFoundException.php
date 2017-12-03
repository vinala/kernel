<?php

namespace Vinala\Kernel\Validation\Exception;

use Vinala\Kernel\Logging\Exception;

/**
 * Language file not found exception.
 */
class ValidationRuleNotFoundException extends Exception
{
    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct($name)
    {
        $this->message = "Rule '".$name."' has not been registered in validations rules.";

        $this->view = config('error.regular');
    }
}
