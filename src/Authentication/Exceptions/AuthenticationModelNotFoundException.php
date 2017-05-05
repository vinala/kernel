<?php

namespace Vinala\Kernel\Authentication\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
 * Authentication Fields Not Found Exception.
 */
class AuthenticationModelNotFoundException extends Exception
{
    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------
    public function __construct()
    {
        $this->message = 'The model used in authentication config not found';

        $this->view = config('error.regular');
    }
}
