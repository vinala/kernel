<?php

namespace Vinala\Kernel\Storage ;

use Vinala\Kernel\Security\Hash;

/**
* The storage session surface
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Storage
* @since v3.3.0
*/
class Session
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	
	/**
	* Surface data array
	*
	* @var array 
	*/
	protected static $register = array() ;


	/**
	* Register name
	*
	* @var string 
	*/
	protected static $register_name = 'VINALA_SESSION_SURFACE' ;
	
	

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		//
	}

	/**
	* Initiate the session surface
	*
	*/
	public static function ini()
	{
		static::start();
	}
	
	

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Start the session surface
	*
	* @return null
	*/
	protected static function start()
	{
		session_start();
	}
	

	/**
	* Check if session is started
	*
	* @return bool
	*/
	public static function isOn( $exception = false)
	{
		if(isset($_SESSION))
		{
			return true;
		}

		exception_if($exception , LogicException::class);

		return false;
	}
	

	/**
	* Load the session register
	*
	* @return bool
	*/
	protected static function load()
	{
		if( ! static::isOn() )
		{
			return false;
		}
		elseif( ! check($_SESSION[static::$register_name]) )
		{
			return false;
		}

		static::$register = $_SESSION[static::$register_name];

		return true;
	}

	/**
	* Save the session register
	*
	* @return bool
	*/
	protected static function save()
	{
		if( ! static::isOn() )
		{
			return false;
		}

		$_SESSION[static::$register_name] = static::$register;

		return true;
	}

	/**
	* Set new session variable
	*
	* @param string $name
	* @param mixed $object
	* @param int $lifetime
	* @return bool
	*/
	public static function put( $name , $object , $lifetime = null)
	{
		static::isOn(true);

		if(is_null($lifetime))
		{
			$lifetime = config('storage.session_lifetime');
		}

		$item = ['name' => $name , 'object' => $object , 'lifetime' => $lifetime];

		static::$register[$name] = $item;

		static::save();

		return true;
	}

	/**
	* Get a seesion variable
	*
	* @param string $name
	* @return mixed
	*/
	public static function get($name)
	{
		static::isOn(true);

		exception_if( ! check(static::$register[$name]) , Exception::class);

		$item = static::$register_name[$name];

		if(($item['lifetime'] < time() && $item['lifetime'] > 0 ) )
		{
			static::remove($name);

			exception(Exception::class);
		}
		else
		{
			return $item['object'];
		}
	}

	/**
	* Check if a session variable is existe
	*
	* @param string $name
	* @return bool
	*/
	public static function exists($name)
	{
		static::isOn(true);

		if( ! check(static::$register[$name]))
		{
			return false;
		}
		else
		{
			$item = static::$register[$name];

			return ($item['lifetime'] > time() || $item['lifetime'] == 0 );
		}
	}
	

	/**
	* Forget and remove a session variable
	*
	* @param string $name
	* @return bool
	*/
	public static function remove($name)
	{
		exception_if( ! static::exists($name) , Exception::class);
		//
		static::$register[$name] = null;

		static::save();

		return true;
	}

	/**
	* Get All session surface variables
	*
	* @return array
	*/
	public static function all()
	{
		return static::$register;
	}
	
	/**
	* Get a session variable and remove it
	*
	* @param string $name
	* @return mixed
	*/
	public static function pull($name)
	{
		$item = static::get($name);

		static::remove($name);

		return $item;
	}

	/**
	* Set and get the session token variable
	*
	* @return string
	*/
	public static function token()
	{
		$name = '#eyuD#BR@w';

		$token = '';

		if(static::existe($name))
		{
			$token = static::get($name);
		}
		else
		{
			$token = Hash::token();
			//
			static::put($name , $token);
		}

		return $token;
	}

}