<?php 

namespace Fiesta\Kernel\Http;

use Fiesta\Kernel\Foundation\Application;
/**
* 
*/
class Root
{
	public static $css;
	public static $js;
	public static $resource;
	public static $images;
	public static $scripts;

	/**
	 * initial function of class
	 */
	public static function ini()
	{
		self::$css      = Application::$root."app/resources/css/";
		self::$js       = Application::$root."app/resources/js/";
		self::$resource = Application::$root."app/resources/";
		self::$images   = Application::$root."app/resources/images/";
		self::$scripts  = Application::$root."app/scripts/";
	}
}

/**
 * calling initial function of class
 */
Root::ini()