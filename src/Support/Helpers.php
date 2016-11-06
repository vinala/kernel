<?php 


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\MVC\View\View;
use Vinala\Kernel\Router\Route;
use Vinala\Kernel\Objects\DateTime;
use Vinala\Kernel\Objects\Table;
use Vinala\Kernel\Translator\Lang;


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

//--------------------------------------------------------
// Array Helpers
//--------------------------------------------------------

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
		if( ! is_array($array)) return $default;
		//
		if (is_null($index)) return $array;
		//
		if (array_key_exists($index , $array)) return $array[$index];
		//
		foreach (explode('.', $index) as $segment) 
		{
            if ( is_array($array) && array_key_exists($segment , $array)) $array = $array[$segment];
            else return $default;
        }
        //
		return $array;
	}	
}

if ( ! function_exists("array_add")) 
{
	/**
	* add item to array
	*
	* @param array $array
	* @param string $index
	* @param string $default
	* @return mixed
	*/
	function array_add( $array , $index = null , $value )
	{
		if( is_null($index) ) $array[] = $value;
		else $array[$index] = $value;
		//
		return $array;
	}	
}

if ( ! function_exists("array_collapse")) 
{
	/**
	* merge many arrays in one array
	*
	* @param array $array
	* @return mixed
	*/
	function array_collapse($array)
	{
		$results = [];
		//
		foreach ($array as $value) {
			$results = array_merge($results, $value);
		}
		//
		return $results;
	}	
}



//--------------------------------------------------------
// String Helpers
//--------------------------------------------------------

if ( ! function_exists("trans")) 
{
	/**
	* get deeply index on array
	*
	* @param string $key
	* @return string
	*/
	function trans( $key )
	{
		return Lang::get($key);
	}	
}

if ( ! function_exists("dot")) 
{
	/**
	* get array from string by dot notation
	*
	* @param string $key
	* @return array
	*/
	function dot( $key )
	{
		return Strings::splite($key , '.');
	}	
}