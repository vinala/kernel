<?php 

namespace Vinala\Kernel\Config;

use Vinala\Kernel\Foundation\Component;

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
			foreach (array_except(self::$aliases , 'kernel') as $aliases) 
			{
				foreach ($aliases as $key => $value) 
				{
					self::set($value,$key);
				}
			}
		}
	}

	protected static function load()
	{
		self::$aliases['kernel'] = config('alias.kernel');
		self::$aliases['user'] = config('alias.user');
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

		d(self::$aliases);

	}

	/**
	* Get documentation of config file
	*
	* @return array
	*/
	protected static function docs()
	{
		return [
			'enable' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Enable Aliases\n\t|----------------------------------------------------------\n\t| Here to activate classes aliases\n\t|\n\t**/",

			'kernel' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Kernel Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of class\n\t| in the kernel.\n\t|\n\t**/",

			'user' => "\n\t/*\n\t|----------------------------------------------------------\n\t| User Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for your aliases, feel\n\t| free to register as many as \n\t| you wish as the aliases are 'lazy' loaded so \n\t| they don't hinder performance.\n\t|\n\t**/",

			'exceptions' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Exceptions Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of exceptions class\n\t| classes\n\t|\n\t**/",

			'controllers' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Controllers Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of controllers class\n\t| classes\n\t|\n\t**/",

			'models' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Models Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of models class\n\t| classes\n\t|\n\t**/",
		];
	}
	


	
	
}
