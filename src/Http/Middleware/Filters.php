<?php

namespace Vinala\Kernel\Http\Middleware;

use Vinala\Kernel\Http\Middleware\Exceptions\MiddlewareNotFoundException;

/**
 * Kernel Filters class.
 */
class Filters
{
    /**
     * Get routes middlewares.
     *
     * @return array
     */
    public static function allRoutesMiddleware()
    {
        return static::$routesMiddleware;
    }

    /**
     * Check if routes middleware exists.
     *
     * @param string $name
     *
     * @return bool
     */
    protected static function existsRoutesMiddleware($name)
    {
        $middleware = self::allRoutesMiddleware();

        return array_has($name);
    }

    /**
     * Get routes middleware.
     *
     * @param string $name
     *
     * @return string
     */
    public static function RoutesMiddleware($name)
    {
        if (!self::existsRoutesMiddleware($name)) {
            throw new MiddlewareNotFoundException($name);
        }
        $middleware = self::allRoutesMiddleware();

        return array_get($middleware, $name);
    }
}
