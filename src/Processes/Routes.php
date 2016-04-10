<?php 

namespace Fiesta\Kernel\Process;

use Fiesta\Kernel\Process\Process;

/**
* Controller class
*/
class Router
{
	public static function get($route)
	{
		$content = self::traitGet($route);
		//
		self::addRoute($content);
		return true;
	}

	protected static function traitGet($route)
	{
		$content = "";
		//
		$content.="\n\n".'Route::get("'.$route.'",function()'."\n";
		$content.='{'."\n";
		$content.="\t".'//'."\n";
		$content.='});';
		//
		return $content;
	}

	protected static function addRoute($content)
	{
		$Root = Process::root;
		$RouterFile 	= $Root."app/http/Routes.php";
		//
		file_put_contents($RouterFile, $content, FILE_APPEND | LOCK_EX);
	}
}