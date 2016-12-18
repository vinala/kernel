<?php 

namespace Vinala\Kernel\Http\Redirect ;

/**
* Main redirect class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Http\Redirect
* @since v3.3.0
*/
class Redirect
{

	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------


	/**
	* Instance of Redirector class
	*
	* @var Vinala\Kernel\Http\Redirect\Redirector
	*/
	protected static $instance = null;
	

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Get and set instance of Redirector
	*	
	* @return Vinala\Kernel\Http\Redirect\Redirector
	*/
	public static function getInstance()
	{
		if( ! is_null(self::$instance))
		{
			return self::$instance;
		}

		self::$instance = cube('redirector');

		return self::$instance;
	}
	

	/**
	* Redirect back function
	*
	* @return bool
	*/
	public static function back()
	{
		return getInstance()->back();
	}
	

}