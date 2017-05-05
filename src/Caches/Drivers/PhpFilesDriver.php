<?php

namespace Vinala\Kernel\Cache\Driver;

use Symfony\Component\Cache\Adapter\PhpFilesAdapter as Adapter;

/**
 * The PHP files cache driver.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class PhpFilesDriver extends Driver
{
    //--------------------------------------------------------
    // Proprties
    //--------------------------------------------------------

    /**
     * The Library used by the driver.
     *
     * @var string
     */
    private $library = 'symfony';

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        $path = '../'.config('cache.options.file.location');
        $lifetime = config('cache.lifetime');

        parent::call(new Adapter('', $lifetime, $path));
    }
}
