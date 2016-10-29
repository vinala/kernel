<?php 

namespace Vinala\Kernel\Log;

use Whoops\Handler\PrettyPageHandler;

/**
* debug class
*/
class Debug
{
	public static function stop($name="User Debug",$array_vars=array())
	{
		if(is_array($name))
		{
			$array_vars=$name;
			$name="User Debug";
		}
		//
		$Handler=new PrettyPageHandler();
		$Handler->handleUserDebug($name,$array_vars);
	}
}
