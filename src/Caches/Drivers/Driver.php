<?php 

namespace Vinala\Kernel\Cache\Driver ;

//use SomeClass;

/**
* File system driver cache
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Cache\Driver
* @since v3.3.0
*/
class Driver
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	/**
	* The Symfony cache adapter
	*
	* @var Symfony\Component\Cache\Adapter 
	*/
	private static $adapter = null ;
	

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		//
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Get the cache value by the key name
	*
	* @param string $key
	* @param [string $default]
	* @return mixed
	*/
	public function get($key , $default = null)
	{
		$item = static::$adapter->getItem($key);

		if ($item->isHit()) 
		{
		    return $item;
		}

		return $default;
	}

	/**
	* Set new cache item
	*
	* @param string $key
	* @param string $value
	* @return mixed
	*/
	public function put($key  , $value)
	{
		$item = static::$adapter->getItem($key);

		$item->set($value);

		static::$adapter->save($item);

		return $item;
	}

	/**
	* Check if there is a key in cache
	*
	* @param string $key
	* @return bool
	*/
	public function has($key)
	{
		$item = static::$adapter->getItem($key);

		return $item->isHit();
	}


	
	


	
	

}	