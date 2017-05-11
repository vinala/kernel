<?php

namespace Vinala\Kernel\Storage;

use Vinala\Kernel\Storage\Exception\CookieKeyNotFoundException;

/**
 * Cookies surface.
 *
 * @version 2.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Cookie
{
    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        //
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Get a cookie.
     *
     * @param string $name
     *
     * @return mixed
     */
    public static function get($name)
    {
        if (self::existe($name)) {
            return $_COOKIE[$name];
        }

        exception(CookieKeyNotFoundException::class, $name);
    }

    /**
     * Check if a cookie exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function exists($name)
    {
        if (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if a cookie exists.
     *
     * @param string $name
     *
     * @deprecated
     *
     * @return bool
     */
    public static function existe($name)
    {
        return self::exists($name);
    }

    /**
     * Create new cookie.
     *
     * @param string $name
     * @param string $value
     * @param int    $lifetime By minutes
     * @param string $path
     *
     * @return null
     */
    public static function create($name, $value, $lifetime, $path = '/')
    {
        $expire = self::lifetime($lifetime);

        return setcookie($name, $value, $expire, $path);
    }

    /**
     * Delete a cookie.
     *
     * @param string $name
     *
     * @return null
     */
    public static function forget($name)
    {
        setcookie($name, '', time() - 999999, '/');
        unset($_COOKIE[$name]);
    }

    /**
     * Set the cookie lifetime.
     *
     * @param int $minutes
     *
     * @return long
     */
    private static function lifetime($minutes)
    {
        $seconds = $minutes * 60;

        return time() + $seconds;
    }
}
