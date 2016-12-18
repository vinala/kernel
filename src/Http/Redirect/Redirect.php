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
	protected static function getInstance()
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
		return self::getInstance()->back();
	}

	/**
	* Redirect to some url
	*
	* @param string $url
	* @param array $extra
	* @param bool $secure
	* @return mixed
	*/
	public static function to($url , $extra = [] , $secure = null)
	{
		return self::getInstance()->to($url , $extra , $secure);
	}
	
	

}