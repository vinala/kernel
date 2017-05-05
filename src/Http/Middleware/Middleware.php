<?php

namespace Vinala\Kernel\Http\Middleware;

use App\Http\Filters as appFilters;
use Vinala\Kernel\Http\Middleware\Exceptions\MiddlewareNotFoundException;

/**
 * Middle ware class.
 */
class Middleware
{
    //--------------------------------------------------------
    // Proprties
    //--------------------------------------------------------

    /**
     * The list of all filters.
     *
     * @var array
     */
    protected static $filters = [];

    /**
     * the password of middleware surface to pass the wall.
     *
     * @var string
     */
    protected static $pass = 'DO_NOTHING';

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Initiate the middleware cube.
     *
     * @return null
     */
    public static function ini()
    {
        self::load();
    }

    /**
     * Run Middleware.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function run($name)
    {
    }

    /**
     * Get Middle ware.
     *
     * @param string $name
     *
     * @return string
     */
    protected static function call($name)
    {
        return appFilters::RoutesMiddleware($name);
    }

    /**
     * Pass the middleware filter.
     *
     * @return string
     */
    public static function next()
    {
        return self::$pass;
    }

    /**
     * Set the list of filters used by middleware.
     *
     * @return array
     */
    protected static function load()
    {
        need(root().'app/http/Filter.php');

        $filter = instance(\App\Http\Filter::class);

        self::$filters['app'] = $filter::$middleware;
        self::$filters['route'] = $filter::$routeMiddleware;

        return self::$filters;
    }

    /**
     * Get the Middleware by filter.
     *
     * @param string $name
     * @param string $key
     *
     * @return string
     */
    public static function get($name)
    {
        if (array_has(self::$filters, 'app.'.$name)) {
            return ['app', array_get(self::$filters, 'app.'.$name)];
        } elseif (array_has(self::$filters, 'route.'.$name)) {
            return ['route', array_get(self::$filters, 'route.'.$name)];
        }

        exception(MiddlewareNotFoundException::class, $name);
    }
}
