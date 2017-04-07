<?php

namespace Vinala\Kernel\Http\Router ;

//use SomeClass;

/**
* The main route surface
*
* @version 3.0
* @author Youssef Had
* @package Vinala\Kernel\Http\Router
* @since v3.3.0
*/
class Route
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
    * The name of the route
    *
    * @var string
    */
    private $name ;

    /**
    * The url of the route
    *
    * @var string
    */
    private $url ;

    /**
    * The closure of the rotue
    *
    * @var Closure
    */
    private $closure ;

    /**
    * The method of http request
    *
    * @var string
    */
    private $method ;

    /**
    * The route middlewares
    *
    * @var array
    */
    private $middleware ;

    /**
    * The resource controller route
    *
    * @var string
    */
    private $resource ;

    /**
    * The subdomains
    *
    * @var array
    */
    private $subdomains ;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct($url)
    {
        $name = $this->format($url);

        $this->url = $url;
        $this->name = $name;
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * Save the route into Routes class
    *
    * @param
    * @param
    * @return
    */
    public static function name()
    {
        
        return ;
    }

    /**
    * Get the current route with slashed at end
    *
    * @return Route
    */
    public function getWithSlash()
    {
        $current = $this;
        
        $current->name .= '/';
        $current->url .= '/';
        return $current;
    }

    /**
    * Format the name and the url of Route
    *
    * @param string $url
    * @return string
    */
    private function format(&$url)
    {
        if ($url == '/') {
            $value = 'project_home';
            $url = '';
        } else {
            $value = $url;
            $url = '/'.$url;
        }
        
        return value;
    }

    /**
    * To set the HTTP method
    *
    * @param string $method
    * @return $this
    */
    private function setMethod($method)
    {
        $this->method = $method ;

        return $this;
    }

    /**
    * Set the closure of route
    *
    * @param Closure $closure
    * @return $this
    */
    private function setClosure($closure)
    {
        $this->closure = $closure ;

        return $this;
    }

    /**
    * Set the subdomains
    *
    * @param string $subdomains
    * @return $this
    */
    public function subDomains($subdomains)
    {
        $domains = explode(',', $subdomains);

        $this->subdomains = $domains;
    }

    //--------------------------------------------------------
    // Static Functions
    //--------------------------------------------------------

    /**
    * To add HTTP get request
    *
    * @param string $url
    * @param Closure $callback
    * @return $this
    */
    public static function get($url, $callback)
    {
        $route = new self($url);
        $route->setClosure($callback);

        return $route;
    }
}
