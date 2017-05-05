<?php

namespace Vinala\Kernel\Translator\Exception;

use Vinala\Kernel\Logging\Exception;

/**
 * Language not supported exception.
 */
class LanguageNotSupportedException extends Exception
{
    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct($lang)
    {
        $this->message = 'The language "'.$lang.'" is not supported by '.(empty(config('app.project')) ? 'the application' : config('app.project'));

        $this->view = config('error.regular');
    }
}
