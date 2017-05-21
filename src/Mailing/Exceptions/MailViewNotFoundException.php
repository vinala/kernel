<?php

namespace Vinala\Kernel\Mailing\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
 * The view not found exception.
 */
class MailViewNotFoundException extends Exception
{
    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        $this->message = "The mailable view not found, add it build() function.";
    }
}
