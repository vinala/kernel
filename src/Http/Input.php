<?php 

namespace Vinala\Kernel\Http ;

/**
* Input Class
*/
class Input
{
	
	/**
	* get $_GET input vars
	*
	* @param mixed $key
	* @param mixed $default
	* @return mixed
	*/
	public static function get($key , $default = null)
	{
		return array_get($_GET , $key , $default);
	}
	

}