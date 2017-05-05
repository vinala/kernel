<?php

namespace Vinala\Kernel\Filesystem\Exception;

/**
 * Directory not fount exception.
 */
class DirectoryNotFoundException extends \Exception
{
    protected $message;

    //
    public function __construct($path)
    {
        $this->message = "Directory does not existe in ($path)";
    }
}
