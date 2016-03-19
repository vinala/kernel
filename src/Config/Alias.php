<?php 

namespace Fiesta\Kernel\Config;

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
		class_alias ( "$target" , $alias);
	}

	protected static function frameworkAliases()
	{
		return 
			array
			(
				'Connector' => \Fiesta\Kernel\Foundation\Connector::class,
			);
	}
}