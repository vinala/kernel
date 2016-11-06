<?php 


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\MVC\View\View;
use Vinala\Kernel\Router\Route;


if( ! function_exists("config"))
{
	/**
	* helper for Config::get function
	*		
	* @param string $key
	* @return mixed
	*/
	function config($key)
	{
		return Config::get($key);
	}
}


if ( ! function_exists("view")) 
{
	/**
	* helper for making view
	*
	* @param string $value
	* @param array $data
	* @return mixed
	*/
	function view( $value , array $data = null )
	{
		return View::make($value,$data);
	}	
}

if ( ! function_exists("get")) 
{
	/**
	* helper for get routing
	*
	* @param string $uri
	* @param callback $callback
	* @param array $subdomains
	* @return mixed
	*/
	function get( $uri , $callback , $subdomains = null )
	{
		return Route::get($uri , $callback , $subdomains);
	}	
}