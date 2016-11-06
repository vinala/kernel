<?php 


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\MVC\View\View;


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
		return Config::get($param);;
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