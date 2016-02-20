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
			//
			foreach (self::$aliases as $key => $value) 
				self::set($value,$key);
		}
		
	}

	protected static function load($root)
	{
		self::$aliases = Config::get('alias.aliases');
		return self::$aliases;
	}

	public static function set($value,$key)
	{
		class_alias ( "$value" , $key);
	}
}