<?php 

namespace Vinala\Kernel\Http\Middleware;

use App\Http\Filters;

/**
* Middle ware class
*/
class Middleware
{
	
	/**
	* Run Middleware
	*
	* @param string $name
	* @return bool
	*/
	public static function run($name)
	{
		
		return ;
	}

	/**
	* Get Middle ware
	*
	* @param string $name		
	* @return string
	*/
	protected static function call($name)
	{
		return Filters::RoutesMiddleware($name);
	}
	
	
}