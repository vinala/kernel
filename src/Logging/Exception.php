<?php

namespace Vinala\Kernel\Logging;

use Exception as E;

/**
 * Main Exception for Vinala default excpetion.
 */
class Exception extends E
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The view name to show if debugging mode was off.
     *
     * @var string
     */
    public $view;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct($message = '', $view = null, $code = 0, $previous = null)
    {
        $this->view = !is_null($view) ? $view : config('error.regular');
        $this->message = $message;
    }
}
