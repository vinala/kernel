<?php

namespace Vinala\Kernel\Caches;

use Vinala\Kernel\Cache\Driver\ApcDriver;
use Vinala\Kernel\Cache\Driver\FileDriver;
use Vinala\Kernel\Cache\Driver\PDODriver;
use Vinala\Kernel\Caches\Exception\DriverNotFoundException;

/**
 * The cache main surface.
 *
 * @version 2.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Cache
{
    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Set the cache surface driver.
     *
     * @return Driver
     */
    private static function driver()
    {
        $options = config('cache.options');

        $driver = config('cache.default');

        switch ($driver) {
            case 'file':
                    return instance(FileDriver::class);
                break;

            case 'apc':
                    return instance(ApcDriver::class);
                break;

            case 'database':
                    return instance(PDODriver::class);
                break;

            default:
                    exception(DriverNotFoundException::class);
                break;
        }
    }

    /**
     * Set an cache item to cache data.
     *
     * @param string $name
     * @param mixed  $value
     * @param int    $lifetime
     *
     * @return null
     */
    public static function put($name, $value, $lifetime)
    {
        return self::driver()->put($name, $value, $lifetime);
    }

    /**
     * Return a value of cache item.
     *
     * @param string $name
     *
     * @return mixed
     */
    public static function get($key)
    {
        return self::driver()->get($key);
    }

    /**
     * Remove item from cache data.
     *
     * @param string $name
     *
     * @return bool|null
     */
    public static function remove($name)
    {
        return self::driver()->remove($name);
    }

    /**
     * Return true item exists in cache data.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function has($name)
    {
        return self::driver()->has($name);
    }

    /**
     * Get item from cache data and remove it.
     *
     * @param string $name
     *
     * @return mixed
     */
    public static function pull($name)
    {
        return self::driver()->pull($name);
    }

    /**
     * Extend lifetime of cache item.
     *
     * @param string $name
     * @param int    $lifetime
     *
     * @return null
     */
    public static function prolong($name, $lifetime)
    {
        return self::driver()->prolong($name, $lifetime);
    }

     /**
     * Extend lifetime of cache item.
     *
     * @param string $name
     * @param int    $lifetime
     *
     * @return null
     */
    public static function clear()
    {
        return self::driver()->clear();
    }
}
