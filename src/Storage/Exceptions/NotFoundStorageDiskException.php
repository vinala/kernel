<?php

namespace Vinala\Kernel\Storage\Exception;

use Vinala\Kernel\Logging\Exception;

/**
 * Not Found Http Exception.
 */
class NotFoundStorageDiskException extends Exception
{
    public function __construct($disk)
    {
        $this->message = 'There is no disk call\'s '.$disk;
        $this->view = config('error.regular');
    }
}
