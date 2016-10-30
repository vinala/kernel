<?php  

namespace Vinala\Kernel\Foundation;

use Vinala\Kernel\Objects\Strings;
use Vinala\Kernel\Config\Config;

/**
* The components class
*/
class Component
{
	
	/**
	* Check if the component is active
	*
	* @param string $name the component name
	* @return bool
	*/
	public static function isOn($name)
	{
		$name = Strings::toLower($name);
		//
		return Config::get("components.".$name);
	}
	
}