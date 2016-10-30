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

	public static function ini($root)
	{
		if(Config::get('alias.enable'))
		{
			self::load($root);
			$frameworkAliases = self::frameworkAliases();
			//
			foreach (self::$aliases as $key => $value) self::set($value,$key);
			foreach ($frameworkAliases as $key => $value) self::set($value,$key);
		}
		
	}

	protected static function load($root)
	{
		self::$aliases = Config::get('alias.aliases');
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
	
}
