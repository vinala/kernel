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
    * All resource routes
    *
    * @var array
    */
    private $resources ;

    /**
    * The route resource target
    *
    * @var array
    */
    private $target ;
    
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
    * To set the Resource target method
    *
    * @param string $method
    * @return $this
    */
    private function setTarget($controller, $method)
    {
        $this->target = ['controller' => $controller , 'method' => $method] ;
        
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

    /**
    * Call resource route
    *
    * @param string $url
    * @param string $controller
    * @return mixed
    */
    public static function resource($url, $controller)
    {
        $route = new self($url);

        $route->setResourceMethods($url, $controller);
        // d(Routes::$register);

        // return $route;
    }

    /**
    * Set the methods resource
    *
    * @param string $url
    * @param string $controller
    * @return null
    */
    private function setResourceMethods($url, $controller)
    {
        //index
        $this->setIndexResource($url, '', $controller);
        $this->setIndexResource($url, '/index', $controller);
        
        //show
        $this->setShowResource($url, '/show/{param}', $controller);

        //add
        $this->setAddResource($url, '/add', $controller);

        //insert
        $this->setInsertResource($url, '/insert', $controller);

        //edit
        $this->setEditResource($url, '/edit/{param}', $controller);

        //update
        $this->setUpdateResource($url, '/update', $controller);
        $this->setUpdateResource($url, '/update/{param}', $controller);

        //delete
        $this->setDeleteResource($url, '/delete/{param}', $controller);
    }

    /**
    * Return a resource closure for resource route
    *
    * @param string $controller
    * @param string $methode
    * @return Closure
    */
    private function getResourceClosure($controller, $method)
    {
        if ($method == 'show' || $method == 'edit' || $method == 'delete') {
            return function ($id) use ($controller, $method) {
                return $controller::$method($id);
            };
        } elseif ($method == 'update') {
            return function ($request, $id) use ($controller, $method) {
                return $controller::$method($request, $id);
            };
        } elseif ($method == 'insert') {
            return function ($request) use ($controller, $method) {
                return $controller::$method($request);
            };
        } else {
            return function () use ($controller, $method) {
                return $controller::$method();
            };
        }
    }

    /**
    * Add resource route
    *
    * @param Route $route
    * @return $this
    */
    private function addResource(Route $route)
    {
        $this->resources[$route->getName()] = $route;
        return $this;
    }

    /**
    * Set a resource routes
    *
    * @param string $url
    * @param string $route
    * @param string $controller
    * @return null
    */
    private function setResource($url, $route, $controller, $target)
    {
        $url = $url.$route;

        $route = new self($url);

        $closure = $this->getResourceClosure($controller, $target);

        $route->setClosure($closure);
        $route->setMethod('resource');
        $route->setTarget($controller, $target);

        $this->addResource($route);
        
        $route->add();
        
        return $route;
    }

    /**
    * Set the index resource routes
    *
    * @param string $url
    * @param string $route
    * @param string $controller
    * @return null
    */
    private function setIndexResource($url, $route = '/index', $controller)
    {
        return $this->setResource($url, $route, $controller, 'index');
    }

    /**
    * Set the show resource routes
    *
    * @param string $url
    * @param string $route
    * @param string $controller
    * @return null
    */
    private function setShowResource($url, $route = '/show/{}', $controller)
    {
        return $this->setResource($url, $route, $controller, 'show');
    }

    /**
    * Set the add resource routes
    *
    * @param string $url
    * @param string $route
    * @param string $controller
    * @return null
    */
    private function setAddResource($url, $route = '/add', $controller)
    {
        return $this->setResource($url, $route, $controller, 'add');
    }

    /**
    * Set the insert resource routes
    *
    * @param string $url
    * @param string $route
    * @param string $controller
    * @return null
    */
    private function setInsertResource($url, $route = '/insert', $controller)
    {
        return $this->setResource($url, $route, $controller, 'insert');
    }

    /**
    * Set the edit resource routes
    *
    * @param string $url
    * @param string $route
    * @param string $controller
    * @return null
    */
    private function setEditResource($url, $route = '/edit/{}', $controller)
    {
        return $this->setResource($url, $route, $controller, 'edit');
    }

    /**
    * Set the update resource routes
    *
    * @param string $url
    * @param string $route
    * @param string $controller
    * @return null
    */
    private function setUpdateResource($url, $route = '/update/{}', $controller)
    {
        return $this->setResource($url, $route, $controller, 'update');
    }

    /**
    * Set the delete resource routes
    *
    * @param string $url
    * @param string $route
    * @param string $controller
    * @return null
    */
    private function setDeleteResource($url, $route = '/delete/{}', $controller)
    {
        return $this->setResource($url, $route, $controller, 'delete');
    }
}
