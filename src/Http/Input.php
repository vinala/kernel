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
	public static function regsiter()
	{
		self::$list = array();
		//
		self::$list['post'] = $_POST;
		self::$list['get'] = $_GET;
		self::$list['session'] = $_SESSION;
		self::$list['cookie'] = $_COOKIE;
		self::$list['files'] = $_FILES;
		self::$list['server'] = $_SERVER;
		self::$list['env'] = $_ENV;
		self::$list['request'] = $_REQUEST;
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
	

	/**
	* get $_GET input vars
	*
	* @param mixed $key
	* @param mixed $default
	* @return mixed
	*/
	public static function get($key , $default = null)
	{
		return array_get(self::$list , 'get.'.$key , $default);
	}


	

}