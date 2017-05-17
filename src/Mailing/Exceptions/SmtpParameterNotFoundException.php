<?php

namespace Vinala\Kernel\Mailing\Exceptions ;

use Vinala\Kernel\Logging\Exception;

/**
 * SMTP Parameter Not Found Exception
 */
class SmtpParameterNotFoundException extends Exception
{

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct($parameter)
    {
        $this->message = "The SMTP $parameter not found in framework configuration";
    }
}
