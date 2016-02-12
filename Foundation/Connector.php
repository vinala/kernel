<?php 

namespace Fiesta\Kernel\Foundation;

use Fiesta\Kernel\Foundation\Application;

/**
* Connector class to call framework core files
*/
class Connector
{

	/**
	 * Require files
	 * @param $path string
	 */
	public static function need($path)
	{
		if(file_exists($path)) require $path;
	}

	/**
	 * Call files
	 * @param $files array
	 * @param $path string
	 */
	public static function call($files,$path)
	{
		foreach ($files as $file) self::need($path.$file.".php");
	}

	/**
	 * Http calls
	 **/
	public static function http()
	{
		require Application::$root.'core/Http/Http.php';
	}

	/**
	 * Logging
	 **/
	public static function logging()
	{
		$files = array('Handler', 'Log');
		$filesPath = Application::$root.'core/Logging/';
		self::call($files,$filesPath);
	}

	/**
	 * Config Core Files
	 **/
	public static function config()
	{
		require Application::$root.'core/Config/Config.php';
		require Application::$root.'core/Config/Exceptions/ConfigException.php';
	}

	/**
	 * Calling Views
	 **/
	public static function view()
	{
		require Application::$root.'core/MVC/View/View.php';
		//
		$files = array('Template', 'Views');
		$filesPath = Application::$root.'core/MVC/View/Libs/';
		self::call($files,$filesPath);
		//
		require Application::$root.'core/MVC/View/Exceptions/ViewNotFoundException.php';
	}

	/**
	 * call vendor
	 */
	public static function vendor()
	{
		self::checkVendor();
		$path = is_null(Application::$root) ? '../vendor/autoload.php' : Application::$root.'vendor/autoload.php';
		include_once $path;
	}

	/**
	 * check if vendor existe
	 */
	public static function checkVendor()
	{
		if( ! file_exists('../vendor/autoload.php')) die("You should install Fiesta dependencies by composer commande 'composer install' :)");
	}

	/**
	 * time call
	 */
	public static function time()
	{
		require Application::$root.'core/Objects/DateTime.php';
	}

	/**
	 * session call
	 */
	public static function session()
	{
		require Application::$root.'core/Storage/Session.php';
	}
}