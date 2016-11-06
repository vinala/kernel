<?php 


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\MVC\View\View;
use Vinala\Kernel\Router\Route;
use Vinala\Kernel\Objects\DateTime;
use Vinala\Kernel\Objects\Table;


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


if ( ! function_exists("call")) 
{
	/**
	* helper for get routing
	*
	* @param string $uri
	* @param string $controller
	* @param array $data
	* @return mixed
	*/
	function call( $uri , $controller , $data = null )
	{
		return Route::call($uri , $controller , $data);
	}	
}


if ( ! function_exists("now")) 
{
	/**
	* helper for current timestamp
	*
	* @return int
	*/
	function now()
	{
		return DateTime::current();
	}	
}


if ( ! function_exists("map")) 
{
	/**
	* helper for var_dump
	*
	* @return null
	*/
	function map($object)
	{
		var_dump($object);
	}	
}


if ( ! function_exists("abort")) 
{
	/**
	* helper for die
	*
	* @return null
	*/
	function abort($object)
	{
		die($object);
	}	
}


if ( ! function_exists("array_get")) 
{
	/**
	* get deeply index on array
	*
	* @param array $array
	* @param string $index
	* @param string $default
	* @return mixed
	*/
	function array_get( $array , $index , $default = null )
	{
		Table::get( $array , $index , $default );
	}	
}