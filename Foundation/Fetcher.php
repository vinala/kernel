<?php 

namespace Fiesta\Kernel\Foundation;

use Fiesta\Kernel\Router\Routes;

/**
* this class help the framework to get all
* app/ folder files
*/
class Fetcher
{
	/**
	 * Path to app folder
	 */
	protected static $path;

	/**
	 * Get all required App files
	 */
	public static function run($routes)
	{
		self::setPath();
		//
		self::model();
		self::controller();
		self::link();
		self::seed();
		self::filtes();
		self::routes($routes);
	}

	/**
	 * Set path to app folder
	 */
	protected static function setPath()
	{
		self::$path = Application::$root."app/";
		return self::$path ; 
	}

	/**
	 * Fetch files of folder
	 */
	protected static function fetch($pattern)
	{
		return glob(self::$path.$pattern);
	}

	/**
	 * Require files of Models folder
	 */
	protected static function model()
	{
		foreach (self::fetch("models/*.php") as $file) 
			Connector::need($file);
	}

	/**
	 * Require files of Controllers folder
	 */
	protected static function controller()
	{
		foreach (self::fetch("controllers/*.php") as $file) 
			Connector::need($file);
	}

	/**
	 * Require files of Links folder
	 */
	protected static function link()
	{
		foreach (self::fetch("links/*.php") as $file) 
			Connector::need($file);
	}

	/**
	 * Require files of Seeds folder
	 */
	protected static function seed()
	{
		foreach (self::fetch("seeds/*.php") as $file) 
			Connector::need($file);
	}

	/**
	 * Require files of Filters
	 */
	protected static function filtes()
	{
		Connector::need(self::$path.'http/Filters.php');
	}

	/**
	 * Require files of Routes
	 */
	protected static function routes($routes)
	{
		if($routes)
			{
				Connector::need(self::$path.'http/Routes.php');
				Routes::run();
			}
	}
	
}