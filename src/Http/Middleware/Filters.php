<?php 

namespace Vinala\Kernel\Http;

/**
* Kernel Filters class
*/
class Filters
{
	/**
	* Get route's filters from middleware
	*
	* @return array
	*/
	public static function allRoutesMiddleware()
	{
		return static::$routesMiddleware;
	}
	
}