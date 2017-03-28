<?php 

namespace Vinala\Kernel\Caches;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Caches\Exception\DriverNotFoundException;
use Vinala\Kernel\Cache\Driver\FileDriver;
use Vinala\Kernel\Cache\Driver\ApcDriver;
use Vinala\Kernel\Cache\Driver\PDODriver;

/**
* Cache class
*/
class Cache
{
	public static function put($key,$value,$minutes)
	{
		return self::driver()->put($key, $value, $minutes);
	}

	public static function get($key)
	{
		return self::driver()->get($key);
	}

	public static function exists($key)
	{
		return self::driver()->exists($key);
	}

	public static function forever($key,$value)
	{
		return self::driver()->forever($key,$value);
	}

	public static function clearOld()
	{
		return self::driver()->clearOld();
	}

	public static function prolongation($key,$minutes)
	{
		return self::driver()->prolongation($key,$minutes);
	}

	public static function pull($key)
	{
		return self::driver()->pull($key);
	}

	protected static function driver()
	{
		$option=Config::get('cache.options');
		$default=Config::get('cache.default');
		//
		switch ($default) {
			case 'file':
				return new FileDriver;
				break;

			case 'apc':
				return new ApcDriver;
				break;
			
			case 'database':
				return new PDODriver;
				break;

			default:
			throw new DriverNotFoundException();
				break;
		}
		


	}

}