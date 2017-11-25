<?php

namespace Vinala\Kernel\Validation\Exception;

use Vinala\Kernel\Logging\Exception;

/**
 * Language file not found exception.
 */
class LanguageFileNotFoundException extends Exception
{
    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct($file)
    {
        $this->message = "There's no file language called '$file'";

        $this->view = config('error.regular');
    }
}
