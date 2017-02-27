<?php 

namespace Vinala\Kernel\Environment ;

//use SomeClass;

/**
* Environment surface
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Environment
* @since v3.3.0
*/
class Environment
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	
	/**
	* The environment variables
	*
	* @var array 
	*/
	protected static $register = array() ;
	

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	/**
	* Initiate the environment surface
	*
	* @return bool
	*/
	public static function ini()
	{
		$path = root().'app/environment.php';

		static::$register = need($path);
	}
	

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Set new variable
	*
	* @param string $key
	* @param mixed $value
	* @return mixed
	*/
	protected static function set($key , $value)
	{
		return static::$register[$key] = $value;
	}

	/**
	* Get a variable
	*
	* @param string $key
	* @param mixed $value
	* @return mixed
	*/
	public static function get($key , $value = null)
	{
		if(array_has(static::$register , $key))
		{
			return static::$register[$key];
		}
		else
		{
			static::set($key , $value);
			return $value;
		}
	}	

}