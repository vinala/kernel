<?php 

namespace Vinala\Kernel\Http ;

/**
* Input Class
*/
class Input
{
	

	/**
	* list of alla input vars
	*
	* @var array 
	*/
	protected static $list ;


	/**
	* regsiter all http input vars
	*
	* @return array
	*/
	public static function register()
	{
		self::$list = array();
		//
		self::$list['post'] = ! isset($_POST) ?: $_POST;
		self::$list['get'] = ! isset($_GET) ?: $_GET;
		self::$list['session'] =  ! isset($_SESSION) ?: $_SESSION;
		self::$list['cookie'] = ! isset($_COOKIE) ?: $_COOKIE;
		self::$list['files'] = ! isset($_FILES) ?: $_FILES;
		self::$list['server'] = ! isset($_SERVER) ?: $_SERVER;
		self::$list['env'] = ! isset($_ENV) ?: $_ENV;
		self::$list['request'] = ! isset($_REQUEST) ?: $_REQUEST;
		//
		return self::$list;
	}
	
	/**
	* get any http vars by 'dot' notation
	*
	* @param string $key
	* @param mixed $default
	* @return mixed
	*/
	public static function reach($key , $default = null)
	{
		return array_get(self::$list , $key , $default);
	}
	

}