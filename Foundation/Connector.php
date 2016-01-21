<?php 

namespace Fiesta\Core\Call;

use Fiesta\Core\Glob\App;

/**
* Connector class to call framework core files
*/
class Connector
{

	/**
	 * Call files
	 * @param $files array
	 * @param $path string
	 */
	public static function call($files,$path)
	{
		foreach ($files as $file)
			require $path.$file.".php";
	}

	/**
	 * Http calls
	 **/
	public static function http()
	{
		require App::$root.'../core/Http/Http.php';
	}

	/**
	 * Logging
	 **/
	public static function logging()
	{
		$files = array('Handler', 'Log');
		$filesPath = App::$root.'../core/Logging/';
		self::call($files,$filesPath);
	}

	/**
	 * Config Core Files
	 **/
	public static function config()
	{
		require App::$root.'../core/Config/Config.php';
		require App::$root.'../core/Config/Exceptions/ConfigException.php';
	}

	/**
	 * Calling Views
	 **/
	public static function view()
	{
		require App::$root.'../core/MVC/View/View.php';
		//
		$files = array('Template', 'Views');
		$filesPath = App::$root.'../core/MVC/View/Libs/';
		self::call($files,$filesPath);
		//
		require App::$root.'../core/MVC/View/Exceptions/ViewNotFoundException.php';
	}

	/**
	 * call vendor
	 */
	public static function vendor()
	{
		self::checkVendor();
		$path = is_null(App::$root) ? '../vendor/autoload.php' : App::$root.'../vendor/autoload.php';
		include_once $path;
	}

	/**
	 * check if vendor existe
	 */
	public static function checkVendor()
	{
		if( ! file_exists('../vendor/autoload.php')) die("You should install fiesta dependencies by composer commande 'composer install' :)");
	}

	/**
	 * time call
	 */
	public static function time()
	{
		require App::$root.'../core/Objects/DateTime.php';
	}

	/**
	 * session call
	 */
	public static function session()
	{
		require App::$root.'../core/Storage/Session.php';
	}
}