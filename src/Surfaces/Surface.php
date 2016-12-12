<?php 

namespace Vinala\Kernel\Surfaces ;

//use SomeClass;

/**
* The main surfaces class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Surfaces
* @since 3.3.0
*/
class Surface
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	/**
	* The last Instance used bu Surface
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
	public static function setInstance($name)
	{
		$name = Accessor::$name();

		static::$instance = new $name;

		return static::$instance;
	}

}