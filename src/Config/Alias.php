<?php 

namespace Vinala\Kernel\Config;

use Vinala\Kernel\Foundation\Component;
use Vinala\Kernel\Process\Alias as Aliases;
use Vinala\Kernel\Config\Exceptions\AliasedClassNotFoundException;

/**
* Alias Class for "lazy"
*/
class Alias
{
	protected static $aliases;
	//

	public static function ini()
	{
		if(config('alias.enable'))
		{
			self::load();

			self::kernelAlias();		
		}
	}

	/**
	* Set aliases for kernel classes
	*
	* @return null
	*/
	public static function kernelAlias()
	{
		if(config('alias.enable'))
		{
			foreach (array_get(self::$aliases ,'kernel') as $key => $value) 
			{
				exception_if( ! class_exists($value) , AliasedClassNotFoundException::class , $value , 'kernel');

				self::set($value,$key);
			}
		}
	}

	/**
	* Set aliases for app classes
	*
	* @return null
	*/
	public static function appAlias()
	{
		if(config('alias.enable'))
		{
			foreach (array_except(self::$aliases , 'kernel') as $array =>$aliases) 
			{
				foreach ($aliases as $key => $value) 
				{
					exception_if( ! class_exists($value) , AliasedClassNotFoundException::class , $value , $array);

					self::set($value,$key);	
				}
			}
		}
	}

	protected static function load()
	{
		self::$aliases['kernel'] = config('alias.kernel');
		self::$aliases['exceptions'] = config('alias.exceptions');
		self::$aliases['controllers'] = config('alias.controllers');
		self::$aliases['models'] = config('alias.models');
		//
		return self::$aliases;
	}

	public static function set($target,$alias)
	{
		switch ($target) 
		{
			case "Vinala\Kernel\Resources\Faker" : self::setIfOn("faker" , $target , $alias); break;
			//
			case "Vinala\Kernel\Database\Database" : self::setIfOn("database" , $target , $alias); break;
			case "Vinala\Kernel\Database\Query" : self::setIfOn("database" , $target , $alias); break;
			case "Vinala\Kernel\Database\DBTable" : self::setIfOn("database" , $target , $alias); break;
			case "Vinala\Kernel\Database\Schema" : self::setIfOn("database" , $target , $alias); break;
			
			default: class_alias ( "$target" , $alias); break;
		}
	}

	protected static function frameworkAliases()
	{
		return 
			array
			(
				'Connector' => \Vinala\Kernel\Foundation\Connector::class,
			);
	}

	/**
	* ckeck if component class is on by user
	*
	* @param string $component
	* @return bool
	*/
	protected static function setIfOn($component , $target , $alias)
	{
		if(Component::isOn($component)) class_alias ( "$target" , $alias);

	}

	/**
	* Update Aliases in alias file
	*
	* @param string $key
	* @param string $class
	* @return bool
	*/
	public static function update($key , $class)
	{
		$indexes = dot($key);

		self::$aliases[$indexes[0]] = array_add(self::$aliases[$indexes[0]] , $indexes[1] , $class);
		self::$aliases['kernel'] = config('alias.kernel');

		Aliases::set(config('alias.enable') , self::$aliases);

	}

	
	


	
	
}
