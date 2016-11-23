<?php

namespace Vinala\Kernel\MVC\View;

/**
* View mother class
*/
class View
{


	public static function make($value,$data=null)
	{
		Views::make($value,$data);
	}

	public static function get($value,$data=null)
	{
		return Views::get($value,$data);
	}

	public static function import($plugin,$value,$data=null)
	{
		return Views::import($plugin,$value,$data);
	}

	/**
	* Check if the view exists
	*
	* @param string $name
	* @return bool
	*/
	public static function exists($name)
	{
		return Views::exists($name);
	}
	


}
