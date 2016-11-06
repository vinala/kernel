<?php 


use Vinala\Kernel\Config\Config;


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