<?php 

namespace Vinala\Kernel\Cache\Driver ;

use Vinala\Kernel\Cache\Item;

/**
* The main driver cache
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
	private $adapter = null ;
	

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Use the driver
	*
	* @param mixed $driver
	* @return null
	*/
	public function call($driver)
	{
		$this->adapter = $driver;
	}
	
	/**
	* Set the cache item
	*
	* @param string $key
	* @return Symfony\Component\Cache\CacheItem | Stash\CacheItem
	*/
	private function set($key ,  $secs = null)
	{
		
		$item = $this->adapter->getItem($key);
		
		if( ! is_null($secs))
		{
			if($secs > 0)
			{
				$item->expiresAfter($secs);
			}
		}

		return $item;
	}
	
	/**
	* Get the cache value by the key name
	*
	* @param string $key
	* @param string $default
	* @return mixed
	*/
	public function get($key , $default = null)
	{
		$item = $this->set($key);
		
		return $item->get();
	}

	/**
	* Set new cache item
	*
	* @param string $key
	* @param string $value
	* @param int $secs
	* @return mixed
	*/
	public function put($key  , $value , $secs = 0)
	{
		$item = $this->set($key , $secs);

		$item->set($value);

		$this->adapter->save($item);
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
		return $this->adapter->deleteItem($key);
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

	/**
	* prolong a lifetime of cache item
	*
	* @param string $key
	* @param int $secs
	* @return mixed
	*/
	public function prolong($key , $secs)
	{
		$item = $this->set($key);

		$expiration = $item->getExpiration()->getTimestamp();

		$now = time();

		if($expiration > $now) 
		{
			$interval = ($expiration - $now) + $secs;
		}
		else
		{
			$interval = $secs;
		}

		$item->expiresAfter($interval); 
		
		$this->adapter->save($item);

		return $item;
	}
	
	
}	