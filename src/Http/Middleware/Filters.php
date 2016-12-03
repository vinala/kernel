<?php 

namespace Vinala\Kernel\Http\Middleware;

/**
* Kernel Filters class
*/
class Filters
{
	/**
	* Get route's middlewares
	*
	* @return array
	*/
	public static function allRoutesMiddleware()
	{
		return static::$routesMiddleware;
	}

	/**
	* Check if middleware exists
	*
	* @param string $name
	* @return bool
	*/
	protected static function existsRoutesMiddleware($name)
	{
		$middleware = self::allRoutesMiddleware();
		
		return array_has($name);
	}
	
	
}