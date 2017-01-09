<?php 

namespace Vinala\Kernel\Collections ;

//use SomeClass;

/**
* The surface who can deal with JSON arrays 
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Collections
* @since v3.3.0
*/
class JSON
{


	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* To Decode a JSON string
	*
	* @param string $string
	* @param bool $assoc
	* @return mixed
	*/
	public static function decode($string , $assoc = false)
	{
		return json_decode($string , ! $assoc);
	}


	/**
	* To Encode an object to JSON string
	*
	* @param mixed $object
	* @param int $option
	* @return string
	*/
	public static function encode($object , $option = 0)
	{
		return json_encode($object , $option);
	}


	/**
	* Get the last error
	*
	* @return string
	*/
	public static function error()
	{
		return json_last_error_msg();
	}
	
	
	

}