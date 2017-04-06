<?php 

namespace Vinala\Kernel\Router;

/**
* Route class
*/

class Route
{
	//protected routes;

	public static function get($uri,$callback,$subdomains=null)
	{
		return Routes::get($uri,$callback,$subdomains);
	}

	public static function post($uri,$callback,$subdomains=null)
	{
		return Routes::get($uri,$callback);
	}

	public static function filter($_name_,$callback,$falsecall=null)
	{
		return Routes::filter($_name_,$callback,$falsecall);
	}

	public static function controller($uri,$controller,$data=null)
	{
		return Routes::resource($uri,$controller,$data);
	}

	public static function call($uri,$controller,$data=null)
	{
		return Routes::call($uri,$controller,$data);
	}

	
	

}

// namespace Vinala\Kernel\Router ;

/**
* The callable router surface
*
* @version 1.1
* @author Youssef Had
* @package Vinala\Kernel\Router
* @since v3.3.0
*/
class Route_
{
	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* The get function for http get route
	*
	* @param string $uri
	* @param callable $callback
	* @param string|array $filter
	* @param array $subdomains
	* @return mixed
	*/
	public static function get($uri , $callback , $filter = null , $subdomains = null )
	{
		return Routes::get_($uri , $callback , $filter , $subdomains);
	}

	/**
	* The post function for HTTP post route
	* @alpha
	*
	* @param string $uri
	* @param callable $callback
	* @param string|array $filter
	* @param array $subdomains
	* @return mixed
	*/
	public static function post($uri , $callback , $filter = null ,$subdomains = null)
	{
		return Routes::get($uri , $callback);
	}

	/**
	* The controller function for HTTP resource route
	*
	* @param string $uri
	* @param string $controller
	* @param string|array $filter
	* @return mixed
	*/
	public static function controller($uri , $controller , $filter = null)
	{
		return Routes::resource($uri,$controller,$data);
	}

	/**
	* The call function for controller function route
	*
	* @param string $uri
	* @param string $controllerFunction
	* @param string|array $filter
	* @return mixed
	*/
	public static function call($uri , $controllerFunction , $filter = null , $data = null)
	{
		return Routes::call($uri , $controllerFunction , $filter , $data);
	}

	/**
	* Get current route
	*
	* @return string
	*/
	public static function current()
	{
		return Routes::current();
	}
}
