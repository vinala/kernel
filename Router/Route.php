<?php 

namespace Fiesta\Core\Router;

/**
* Route class
*/

class Route
{
	//protected routes;

	public static function get($uri,$callback,$subdomains=null)
	{
		return Routes::get($uri,$callback,$subdomains);
	}

	public static function post($uri,$callback,$subdomains=null)
	{
		return Routes::get($uri,$callback);
	}

	public static function filter($_name_,$callback,$falsecall=null)
	{
		return Routes::filter($_name_,$callback,$falsecall);
	}

	public static function controller($uri,$controller,$data=null)
	{
		return Routes::resource($uri,$controller,$data);
	}

	public static function call($uri,$controller,$data=null)
	{
		return Routes::call($uri,$controller,$data);
	}

}
