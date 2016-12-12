<?php 

namespace Vinala\Kernel\Cubes ;

//use SomeClass;

/**
* The main cubes class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Cubes
* @since 3.3.0
*/
class Cube
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	/**
	* The last Instance used by cube
	*
	* @var mixed 
	*/
	public static $instance;

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Set Instance
	*
	* @param string $name
	* @return mixed
	*/
	public static function setInstance($args)
	{
		$name = array_shift($args);

		$name = self::getAccessor($name);

		static::$instance = new $name(...$args);

		return static::$instance;
	}


	/**
	* Get the cube name
	*
	* @param $name
	* @return string
	*/
	protected static function getAccessor($name)
	{
		return Accessor::$name();
	}
	

}