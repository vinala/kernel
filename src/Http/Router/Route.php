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
    public $url ;
    
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
    * @return null
    */
    private function add()
    {
        Routes::add($this);
    }

    /**
    * Save the edits of the route into Routes class
    *
    * @return null
    */
    private function edit()
    {
        Routes::edit($this);
    }
    
    /**
    * Get the current route with slashed at end
    *
    * @return Route
    */
    public function getWithSlash()
    {
        $route = clone $this;
        
        $route->name .= '/';
        $route->url .= '/';
        
        return $route;
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
        
        return $value;
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

    /**
    * Set middlewares for the route
    *
    * @return Route
    */
    public function middleware()
    {
        $args = func_get_args();

        $this->middleware = $args;

        $this->edit();

        return $this;
    }
    
    //--------------------------------------------------------
    // Getters and setters
    //--------------------------------------------------------
    
    /**
    * To get the name of route
    *
    * @return $this
    */
    public function getName()
    {        
        return $this->name;
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
    * get the subdomains of route
    *
    * @return array
    */
    public function getSubdomain()
    {
        return $this->subdomains;
    }
    
    /**
    * get the method of route
    *
    * @return array
    */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
    * get the target of route
    *
    * @return string
    */
    public function getTarget()
    {
        return $this->target;
    }
    
    /**
    * Get the closure of route
    *
    * @return Closure
    */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
    * Get the middleware of route
    *
    * @return array|null
    */
    public function getMiddleware()
    {
        return $this->middleware;
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
        $route->setMethod('get');
        
        $route->add();
        
        return $route;
    }
    
    /**
    * To add HTTP post request
    *
    * @param string $url
    * @param Closure $callback
    * @return $this
    */
    public static function post($url, $callback)
    {
        $route = new self($url);
        $route->setClosure($callback);
        $route->setMethod('post');
        
        $route->add();
        
        return $route;
    }
}