<?php

namespace Vinala\Kernel\Cache\Driver;

use Stash\Pool;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as Adapter;

/**
 * The file system cache driver.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class FileDriver extends Driver
{
    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        $path = '../'.config('cache.options.file.location');
        $lifetime = config('cache.lifetime');

        // Set the driver
        $driver = new Adapter('', $lifetime, $path);

        // Set the Pool
        parent::call($driver);
    }
}
