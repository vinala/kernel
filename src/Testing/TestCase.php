<?php 

namespace Fiesta\Kernel\Testing;

use PHPUnit_Framework_TestCase;
use Fiesta\Kernel\Foundation\Application;


/**
* TestCase Class For testing
*/
class TestCase
{
	
	/**
	 * Run the test
	 */
	public static function run()
	{
		self::call();
		//
		return self::mock();
	}

	/**
	 * Call the Fiesta Framework
	 */
	public static function call()
	{
		require_once __DIR__.'/../Foundation/Application.php';
	}

	/**
	 * Return instance the Framework App Class
	 */
	public static function instance($path)
	{
		return Application::run("",$path,false,false);
	}

	/**
	 * Check if App Class retruns true
	 */
	public static function mock()
	{
		return self::instance(__DIR__."/../");
	}
}

