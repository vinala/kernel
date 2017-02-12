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
	* Set the cache item
	*
	* @param string $key
	* @return Symfony\Component\Cache\CacheItem
	*/
	private function set($key)
	{
		return static::$adapter->getItem($key);
	}
	
	/**
	* Get the cache value by the key name
	*
	* @param string $key
	* @param [string $default]
	* @return mixed
	*/
	public function get($key , $default = null)
	{
		$item = $this->set($key);

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
		$item = $this->set($key);

		$item->set($value);

		static::$adapter->save($item);

		return $item;
	}

	/**
	* Check if there is an item in cache
	*
	* @param string $key
	* @return bool
	*/
	public function has($key)
	{
		$item = $this->set($key);

		return $item->isHit();
	}

	/**
	* Remove a cache item
	*
	* @param string $key
	* @return bool
	*/
	public function remove($key)
	{
		return static::$adapter->deleteItem($key);
	}

	/**
	* Get an item cache and remove it
	*
	* @param string $key
	* @return mixed
	*/
	public function pull($key)
	{
		$item = $this->get($key);

		$this->remove($key);

		return $item;
	}
	
	
	
	
	


	
	

}	