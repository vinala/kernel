<?php

namespace Fiesta\Kernel\Foundation;

use Fiesta\Kernel\Storage\Session;
use Fiesta\Kernel\Logging\Handler;
use Fiesta\Kernel\Config\Alias;
use Fiesta\Kernel\Objects\Sys;
use Fiesta\Kernel\Access\Url;
use Fiesta\Kernel\Access\Path;
use Fiesta\Kernel\MVC\View\Template;
use Fiesta\Kernel\Resources\Faker;
use Fiesta\Kernel\Http\Links;
use Fiesta\Kernel\Http\Errors;
use Fiesta\Kernel\Security\License;
use Fiesta\Kernel\Translator\Lang;
use Fiesta\Kernel\Database\Database;
use Fiesta\Kernel\Security\Auth;
use Fiesta\Kernel\Router\Routes;
use Fiesta\Kernel\Config\Config;
use Fiesta\Kernel\Logging\Log;
use Fiesta\Kernel\Objects\DateTime;
use Fiesta\Vendor\Panel\Panel;
use Fiesta\Kernel\Filesystem\Filesystem;
use Fiesta\Kernel\Plugins\Plugins;


class Application
{
	static $page;
	public static $root;
	public static $Callbacks = array('before'=>null,'after'=>null);

	public static function version()
	{
		$version=(new Filesystem)->get(self::$root."version.md");
		return "Fiesta v3.1 ($version) PHP Framework";
	}

	public static function fullVersion()
	{
		return (new Filesystem)->get(self::$root."version.md");
	}

	public static function kernelVersion()
	{
		$kernel = "vendor/fiesta/kernel/";
		$version=(new Filesystem)->get(self::$root.$kernel."version.md");
		return "Fiesta Kernel v".$version;
	}

	protected static function callConnector()
	{
		require self::$root.'vendor/fiesta/kernel/src/Foundation/Connector.php';
	}


	/**
	 * Set the root of the framework for basic path
	 * @param $root string
	 */
	protected static function setRoot($root)
	{
		self::$root=$root;
		return $root;
	}

	/**
	 * start recording the output to screen
	 */
	protected static function setScreen()
	{
		ob_start();
	}

	/**
	 * Run the Framework
	 */
	public static function run($root="../",$routes=true,$session=true)
	{
		self::setScreen();
		self::setRoot($root);

		// call the connector and run it
		self::callConnector();
		Connector::run();
		//
		self::ini();
		//
		self::fetcher($routes);
		//
		return true;
	}

	/**
	 * Init Framework classes
	 */
	protected static function ini()
	{
		Alias::ini(self::$root);
		Sys::ini();
		Url::ini();
		Path::ini();
		Template::run();
		Faker::ini();
		Links::ini();
		Errors::ini(self::$root);
		License::ini(self::$page);
		Lang::ini();
		Database::ini();
		Auth::ini();
		Panel::run();
		Plugins::ini();
	}

	/**
	 * Calling the fetcher
	 */
	protected static function fetcher($routes)
	{
		Connector::need(self::$root.'vendor/fiesta/kernel/src/Foundation/Fetcher.php');
		Fetcher::run($routes);
	}

	/**
	 * call vendor
	 */
	public static function vendor()
	{
		self::checkVendor();
		$path = is_null(self::$root) ? 'vendor/autoload.php' : self::$root.'vendor/autoload.php';
		include_once $path;
	}

	public static function before($fun)
	{
		self::$Callbacks['before']=$fun;
	}

	public static function after($fun)
	{
		self::$Callbacks['after']=$fun;
	}

	public static function root()
	{
		$sub=$_SERVER["PHP_SELF"];
		$r=explode("App.php", $sub);
		//
		return "http://".$_SERVER["HTTP_HOST"].$r[0];
	}
}
