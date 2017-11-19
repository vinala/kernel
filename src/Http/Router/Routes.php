<?php

namespace Vinala\Kernel\Http\Router;

use App\Http\Filter;
use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Http\Request;
use Vinala\Kernel\Http\Router\Exceptions\NotFoundHttpException;
use Vinala\Kernel\Http\Router\Exceptions\RouteDuplicatedException;
use Vinala\Kernel\Http\Router\Exceptions\RouteMiddlewareNotFoundException;
use Vinala\Kernel\Http\Router\Exceptions\RouteNotFoundInRoutesRegisterException;
use Vinala\Kernel\MVC\View;
use Vinala\Kernel\MVC\Views;

/**
 * The routes class where framework store all kind of routes.
 *
 * @version 2.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 **/
class Routes
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The routes register.
     *
     * @var array
     **/
    public static $register = [];

    /**
     * The current route.
     *
     * @var Route
     **/
    private static $current;

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
     * Run the router.
     *
     * @return null
     **/
    public static function run()
    {
        $request = static::getRequest();

        $root = static::setRoot($request);

        static::cleanUrls();

        static::fetch($request);
    }

    /**
     * Fetch all routes in $request and work on them.
     *
     * @param string $current
     *
     * @return bool
     **/
    private static function fetch($current)
    {
        $result = false;

        foreach (static::$register as $route) {
            $url = $route->url;

            if (preg_match("#^$url$#", $current, $param)) {
                if (!is_null($route->getSubdomain())) {
                    if (Collection::contains($route->getSubdomain(), static::getSubDomain())) {
                        $result = static::treat($route, $param);
                        if ($result) {
                            break;
                        }
                    }
                } else {
                    $result = static::treat($route, $param);
                    if ($result) {
                        break;
                    }
                }
            }
        }

        exception_if(!$result, NotFoundHttpException::class);
    }

    /**
     * Get user request from _framework_url_ in get array.
     *
     * @return string
     **/
    private static function getRequest()
    {
        $url = '/'.request('_framework_url_', '', 'get');

        unset($_GET['_framework_url_']);

        return $url;
    }

    /**
     * Set the app root param.
     *
     * @param string $url
     *
     * @return string
     **/
    private static function setRoot($url)
    {
        $segements = explode('/', $url);
        $count = count($segements) - 2;

        $path = '';

        for ($i = 0; $i < $count; $i++) {
            $path .= '../';
        }

        Application::$path .= $path;

        return Application::$path;
    }

    /*
    * Clean the url if there is dynamic parts in it
    * and delete strings between brackets {}
    *
    * @param string $url
    * @return string
    ***/
    private static function cleanUrl($url)
    {
        $result = '';
        $inner = false;

        for ($i = 0; $i < strlen($url); $i++) {
            if (!$inner) {
                if ($url[$i] != '{') {
                    $result .= $url[$i];
                } else {
                    $result .= '{';
                    $inner = true;
                }
            } else {
                if ($url[$i] == '}') {
                    $result .= '}';
                    $inner = false;
                }
            }
        }

        return $result;
    }

    /**
     * Clean all routes url and change string between brackets to '(.*)?'.
     *
     * @return null
     */
    private static function cleanUrls()
    {
        foreach (static::$register as $route) {
            $route->url = static::cleanUrl($route->url);
        }

        foreach (static::$register as $route) {
            if (str_contains($route->url, '{}')) {
                $route->url = str_replace('{}', '(.*)?', $route->url);
            }
        }
    }

    /**
     * Get the subdomain of the current request.
     *
     * @return string
     */
    private static function getSubDomain()
    {
        return request('SERVER_NAME', null, 'server');
    }

    /**
     * Treat the request according to it's method.
     *
     * @param Route $route
     * @param array $params
     *
     * @return bool
     **/
    private static function treat(Route $route, $params)
    {
        // in case of get request or post request
        if (($route->getMethod() == 'post' && Request::isPost()) || ($route->getMethod() == 'get') || ($route->getMethod() == 'resource') || ($route->getMethod() == 'call')) {
            return static::execute($route, $params);
        }

        return false;
    }

    /**
     * Execute the route.
     *
     * @param Route $one
     * @param array $params
     *
     * @return bool
     **/
    private static function execute(&$route, $params)
    {
        array_shift($params);

        if (static::runAppMiddleware() && static::runRouteMiddleware($route)) {
            static::prepare($route, $params);

            return true;
        }
    }

    /**
     * Check app middlewares before run the route.
     *
     * @return null
     **/
    private static function runAppMiddleware()
    {
        $appMiddleware = Filter::$middleware;

        foreach ($appMiddleware as $middleware) {
            $middleware = instance($middleware);

            $middleware->handle(new Request());
        }

        return true;
    }

    /**
     * Check route middlewares before run the route
     * and check if the requested middleware are realy in filter class.
     *
     * @return null
     **/
    private static function runRouteMiddleware($route)
    {
        $routeMiddleware = Filter::$routeMiddleware;

        if (!is_null($route->getMiddleware())) {
            // if ($route->getMiddleware()['type'] == 'route' && ! is_null($route->getMiddleware()['middlewares'])) {
            foreach ($route->getMiddleware() as $middleware) {
                //Check if the routes middlewares are in filter class
                exception_if(!array_has($routeMiddleware, $middleware), RouteMiddlewareNotFoundException::class, $middleware);

                $middleware = instance($routeMiddleware[$middleware]);

                $middleware->handle(new Request());
            }
        }

        return true;
    }

    /**
     * prepare the route to be executed.
     *
     * @param Route $request
     * @param array $params
     *
     * @return null
     **/
    private static function prepare(Route $route, $params)
    {
        static::$current = $route;

        if ($route->getMethod() == 'resource') {
            if ($route->getTarget()['method'] == 'update') {
                $id = $params[0];
                $params[0] = new Request();
                $params[] = $id;
            } elseif ($route->getTarget()['method'] == 'insert') {
                $params[] = new Request();
            }
            self::treatment(call_user_func_array($route->getClosure(), $params));
        } elseif ($route->getMethod() == 'call') {
            $target = $route->getResource()[$route->name]->getTarget();

            self::treatment(call_user_func_array([$target['controller'], $target['method']], $params));
        } else {
            self::treatment(call_user_func_array($route->getClosure(), $params));
        }
    }

    /**
     * Treat the result of the route closure.
     *
     * @param mixed $result
     *
     * @return string
     **/
    private static function treatment($result)
    {
        if (is_string($result)) {
            echo $result;
        } elseif ($result instanceof Views) {
            View::show($result);
        }
    }

    /**
     * Add new route to register.
     *
     * @param Route $route
     *
     * @return null
     **/
    public static function add(Route $route)
    {
        exception_if(self::checkDuplicated($route), RouteDuplicatedException::class, $route);

        // Create new route for url ended with '/'
        $routeWithoutSlash = $route;
        $routeWithSlash = $route->getWithSlash();

        self::$register[$routeWithoutSlash->getName()] = $routeWithoutSlash;
        self::$register[$routeWithSlash->getName()] = $routeWithSlash;
    }

    /**
     * Update an existant route in register.
     *
     * @param Route $route
     *
     * @return null
     **/
    public static function edit(Route $route)
    {
        $routeWithoutSlash = $route;
        $routeWithSlash = $route->getWithSlash();

        self::$register[$routeWithoutSlash->getName()] = $routeWithoutSlash;
        self::$register[$routeWithSlash->getName()] = $routeWithSlash;
    }

    /**
     * Remove an existant route from register.
     *
     * @param Route $route
     *
     * @return null
     */
    public static function delete(Route $route)
    {
        $routeWithoutSlash = $route;
        $routeWithSlash = $route->getWithSlash();

        // exception_if(! check(self::$register[$routeWithoutSlash->getName()]), RouteNotFoundInRoutesRegisterException::class , $routeWithoutSlash);
        // exception_if(! check(self::$register[$routeWithSlash->getName()]), RouteNotFoundInRoutesRegisterException::class , $routeWithSlash);

        if (check(self::$register[$routeWithoutSlash->getName()])) {
            unset(self::$register[$routeWithoutSlash->getName()]);
        }

        if (check(self::$register[$routeWithSlash->getName()])) {
            unset(self::$register[$routeWithSlash->getName()]);
        }
    }

    /**
     * Check if route is duplicated.
     *
     * @param Route $route
     *
     * @return bool
     **/
    private static function checkDuplicated(Route $route)
    {
        foreach (self::$register as $registeredRoute) {
            if ($registeredRoute->getName() == $route->getName()) {
                return true;
            }
        }

        return false;
    }
}
