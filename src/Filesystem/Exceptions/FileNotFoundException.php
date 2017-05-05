<?php

namespace Vinala\Kernel\Filesystem\Exception;

/**
 * File not fount exception.
 */
class FileNotFoundException extends \Exception
{
    protected $message;   // exception message

    public function __construct($path)
    {
        $this->message = "File does not existe in ($path)";
    }
}
