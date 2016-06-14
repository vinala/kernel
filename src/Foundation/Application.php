<?php

namespace Lighty\Kernel\Foundation;

use Lighty\Kernel\Storage\Session;
use Lighty\Kernel\Logging\Handler;
use Lighty\Kernel\Config\Alias;
use Lighty\Kernel\Objects\Sys;
use Lighty\Kernel\Access\Url;
use Lighty\Kernel\Access\Path;
use Lighty\Kernel\MVC\View\Template;
use Lighty\Kernel\Resources\Faker;
use Lighty\Kernel\Http\Links;
use Lighty\Kernel\Http\Errors;
use Lighty\Kernel\Security\License;
use Lighty\Kernel\Translator\Lang;
use Lighty\Kernel\Database\Database;
use Lighty\Kernel\Security\Auth;
use Lighty\Kernel\Router\Routes;
use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Logging\Log;
use Lighty\Kernel\Objects\DateTime;
use Lighty\Panel;
use Lighty\Kernel\Filesystem\Filesystem;
use Lighty\Kernel\Plugins\Plugins;
use Lighty\Kernel\Storage\Cookie;


class Application
{
	static $page;
	public static $root;
	public static $Callbacks = array('before'=>null,'after'=>null);

	/**
	 * True if the framework in test case
	 */
	public static $isTest;

	/**
	 * True if the framework use console
	 */
	public static $isConsole = false;




	public static function version()
	{
		$version=(new Filesystem)->get(self::$root."version.md");
		return "Lighty v3.2 ($version) PHP Framework";
	}

	public static function consoleVersion()
	{
		$version=(new Filesystem)->get(self::$root."version.md");
		return "Lighty v3.2 ($version) PHP Framework";
	}

	public static function fullVersion()
	{
		return (new Filesystem)->get(self::$root."version.md");
	}

	public static function kernelVersion()
	{
		$kernel = "vendor/lighty/kernel/";
		$version=(new Filesystem)->get(self::$root.$kernel."version.md");
		return "Lighty Kernel v".$version;
	}

	public static function setVersionCookie()
	{
		$version = (new Filesystem)->get(self::$root."version.md");
		Cookie::create("lighty_version", $version,3);
	}

	protected static function callConnector($test = false)
	{

		require $test ? 'src/Foundation/Connector.php' : self::$root.'vendor/lighty/kernel/src/Foundation/Connector.php';

		require $test ? 'src/Foundation/Exceptions/ConnectorFileNotFoundException.php' : self::$root.'vendor/lighty/kernel/src/Foundation/Exceptions/ConnectorFileNotFoundException.php';

	}

	/**
	 * Using Connector in console
	*/
	protected static function consoleConnector()
	{
		require 'vendor/lighty/kernel/src/Foundation/Connector.php';
		require 'vendor/lighty/kernel/src/Foundation/Exceptions/ConnectorFileNotFoundException.php';
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

	public static function setCaseVars($isConsole , $isTest)
	{
		self::$isConsole = $isConsole;
		self::$isTest = $isTest;
	}
	/**
	 * Run the Framework
	 */
	public static function run($root="../",$routes=true,$session=true)
	{
		self::setScreen();
		self::setRoot($root);
		//
		self::setCaseVars(false,false);

		// call the connector and run it
		self::callConnector();
		Connector::run(false,$session);
		// set version cookie for Wappalyzer
		self::setVersionCookie();
		//
		self::ini();
		//
		self::fetcher($routes);
		//
		return true;
	}

	public static function consoleServerVars()
	{
		$_SERVER["HTTP_HOST"] = "localhost";
		$_SERVER['REQUEST_URI'] = "";
	}

	/**
	 * Run the console
	 */
	public static function console($root="",$session=true)
	{

		self::setCaseVars(true,false);
		//
		self::consoleServerVars();
		//
		self::setScreen();
		self::setRoot($root);
		//
	
		// call the connector and run it
		self::consoleConnector();
		Connector::run(true); 
		//
		self::ini();
		//
		self::fetcher(false);
		//
		return true;
	}

	/**
	 * Run the Framework
	 */
	public static function runTest($root="../",$routes=true,$session=true)
	{
		self::setScreen();
		self::setRoot($root);
		//
		self::$isTest = true;
		// call the connector and run it
		self::callConnector(true);
		Connector::runTest(true);
		// set version cookie for Wappalyzer
		self::setVersionCookie();
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
		Connector::need(self::$root.'vendor/lighty/kernel/src/Foundation/Fetcher.php');
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
		// $host = (isset($_SERVER["HTTP_HOST"]) && ! empty()) ? "localhost"
		return "http://".$_SERVER["HTTP_HOST"].$r[0];
	}

	public static function test()
	{
		self::setScreen();
		self::setRoot("../");
		// //
		self::$isTest = true;
		// // call the connector and run it

		self::callConnector(true);
		Connector::runTest(true);
		
		// //
		// self::ini();
		// //
		// self::fetcher($routes);
		//
		return true;
	}
}
