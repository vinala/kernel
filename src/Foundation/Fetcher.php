<?php 

namespace Lighty\Kernel\Foundation;

use Lighty\Kernel\Router\Routes;

/**
* this class help the framework to get all
* app/ folder files
*/
class Fetcher
{
	/**
	 * Path to app folder
	 */
	protected static $appPath;

	/**
	 * Path to framework folder
	 */
	protected static $frameworkPath;

	/**
	 * Get all required App files
	 */
	public static function run($routes)
	{
		self::setAppPath();
		self::setFrameworkPath();
		//
		self::model();
		self::controller();
		self::link();
		self::seed();
		self::filtes();
		self::routes($routes);
		self::commands();
	}

	/**
	 * Set path to app folder
	 */
	protected static function setAppPath()
	{
		self::$appPath = Application::$root."app/";
		return self::$appPath ; 
	}

	/**
	 * Set path to app folder
	 */
	protected static function setFrameworkPath()
	{
		self::$frameworkPath = Application::$root;
		return self::$frameworkPath ; 
	}

	/**
	 * Fetch files of folder
	 */
	protected static function fetch($pattern,$app = true)
	{
		if($app) return glob(self::$appPath.$pattern.'/*.php');
		else return glob(self::$frameworkPath.$pattern.'/*.php');
	}

	/**
	 * Require files of Models folder
	 */
	protected static function model()
	{
		foreach (self::fetch("models") as $file) 
			Connector::need($file);
	}

	/**
	 * Require files of Controllers folder
	 */
	protected static function controller()
	{
		foreach (self::fetch("controllers") as $file) 
			Connector::need($file);
	}

	/**
	 * Require files of Links folder
	 */
	protected static function link()
	{
		foreach (self::fetch("links") as $file) 
			Connector::need($file);
	}

	/**
	 * Require files of Seeds folder
	 */
	protected static function seed()
	{
		foreach (self::fetch("database/seeds" , false) as $file) 
			Connector::need($file);
	}

	/**
	 * Require files of Filters
	 */
	protected static function filtes()
	{
		Connector::need(self::$appPath.'http/Filters.php');
	}

	/**
	 * Require files of Routes
	 */
	protected static function routes($routes)
	{
		if($routes)
			{
				Connector::need(self::$appPath.'http/Routes.php');
				Routes::run();
			}
	}

	/**
	 * Require files of Console
	 */
	protected static function commands()
	{
		foreach (self::fetch("console/commands") as $file) 
			Connector::need($file);
	}
	
}