<?php

namespace Vinala\Kernel\MVC\View\Exception;

/**
 * Directory not fount exception.
 */
class ViewNotFoundException extends \Exception
{
    public function __construct($view)
    {
        $this->message = "There is no view call '$view' in Views folder";
    }
}
