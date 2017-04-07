<?php

namespace Vinala\Kernel\Http\Router ;

use Vinala\Kernel\Http\Router\Exceptions\RouteDuplicatedException;

/**
* The routes class where framework store all kind of routes
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Http\Router
* @since v3.3.0
*/
class Routes
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
    * The routes register
    *
    * @var array
    */
    private static $register = [];

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct()
    {
        //
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * Add new route to register
    *
    * @param Route $route
    * @return null
    */
    public static function add(Route $route)
    {
        exception_if(self::checkDuplicated($route), RouteDuplicatedException::class, $route);

        // Create new route for url ended with '/'
        $routeWithoutSlash = $route;
        $routeWithSlash = $route->getWithSlash();

        self::$register[] = $routeWithoutSlash;
        self::$register[] = $routeWithSlash;

        return ;
    }

    /**
    * Check if route is duplicated
    *
    * @param Route $route
    * @return bool
    */
    private static function checkDuplicated(Route $route)
    {
        foreach (self::$register as $registeredRoute) {
            if ($registeredRoute->name == $route->name) {
                return true;
            }
        }

        return false;
    }
}
