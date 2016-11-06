<?php 


use Vinala\Kernel\Config\Config;


if( ! function_exists(Config))
{
	/**
	* helper for Config::get function
	*		
	* @param string $key
	* @return mixed
	*/
	function Config($key)
	{
		return Config::get($param);;
	}
}