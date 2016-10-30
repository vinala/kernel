<?php

namespace Vinala\Kernel\Foundation;

use Vinala\Kernel\Storage\Session;
use Vinala\Kernel\Logging\Handler;
use Vinala\Kernel\Config\Alias;
use Vinala\Kernel\Objects\Sys;
use Vinala\Kernel\Access\Url;
use Vinala\Kernel\Access\Path;
use Vinala\Kernel\MVC\View\Template;
use Vinala\Kernel\Resources\Faker;
use Vinala\Kernel\Http\Links;
use Vinala\Kernel\Http\Errors;
use Vinala\Kernel\Security\License;
use Vinala\Kernel\Translator\Lang;
use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Security\Auth;
use Vinala\Kernel\Router\Routes;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Logging\Log;
use Vinala\Kernel\Objects\DateTime;
use Vinala\Panel;
use Vinala\Kernel\Filesystem\Filesystem;
use Vinala\Kernel\Plugins\Plugins;
use Vinala\Kernel\Storage\Cookie;


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
		return "Lighty v$version PHP Framework";
	}

	public static function consoleVersion()
	{
		return (new Filesystem)->get(self::$root."version.md");
	}

	public static function fullVersion()
	{
		return (new Filesystem)->get(self::$root."version.md");
	}

	public static function kernelVersion()
	{
		$kernel = "vendor/vinala/kernel/";
		$version=(new Filesystem)->get(self::$root.$kernel."version.md");
		return "Lighty Kernel v".$version;
	}

	/**
	 * Set Lighty version cookie
	 */
	public static function setVersionCookie()
	{
		$version = (new Filesystem)->get(self::$root."version.md");
		Cookie::create("lighty_version", $version,3);
	}

	protected static function callConnector($test = false)
	{

		require $test ? 'src/Foundation/Connector.php' : self::$root.'vendor/vinala/kernel/src/Foundation/Connector.php';

		require $test ? 'src/Foundation/Exceptions/ConnectorFileNotFoundException.php' : self::$root.'vendor/vinala/kernel/src/Foundation/Exceptions/ConnectorFileNotFoundException.php';

	}

	/**
	 * Using Connector in console
	*/
	protected static function consoleConnector()
	{
		require 'vendor/vinala/kernel/src/Foundation/Connector.php';
		require 'vendor/vinala/kernel/src/Foundation/Exceptions/ConnectorFileNotFoundException.php';
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
		self::setSHA();
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
		self::ini(false);
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
		self::callConnector();
		Connector::run(false,$session);
		// set version cookie for Wappalyzer
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
	protected static function ini($database = true)
	{
		Alias::ini(self::$root);
		Sys::ini();
		Url::ini();
		Path::ini();
		Template::run();
		if(Component::isOn("faker")) Faker::ini();
		Links::ini();
		Errors::ini(self::$root);
		License::ini(self::$page);
		Lang::ini();
		if($database) Database::ini();
		Auth::ini();
		Panel::run();
		Plugins::ini();
	}

	/**
	 * Calling the fetcher
	 */
	protected static function fetcher($routes)
	{
		Connector::need(self::$root.'vendor/vinala/kernel/src/Foundation/Fetcher.php');
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

	/**
	* Set SHA Code
	*/
	public static function setSHA()
	{
		$SHA = "97e88f56e4dd302eeac7a7cb0367f966f1adaa815ba77be2b410132d4768bfbd";
		Cookie::create("sha256", $SHA ,3);
	}
}
