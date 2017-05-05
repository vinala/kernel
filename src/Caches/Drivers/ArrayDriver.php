<?php

namespace Vinala\Kernel\Cache\Driver;

use Symfony\Component\Cache\Adapter\ArrayAdapter as Adapter;

/**
 * The array cache driver.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class ArrayDriver extends Driver
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
        $lifetime = config('cache.lifetime');
        $serialize = config('cache.options.array.serialize');

        parent::call(new Adapter($lifetime, $serialize));
    }
}
