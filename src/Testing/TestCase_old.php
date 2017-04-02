<?php 

namespace Vinala\Kernel\Testing;

use PHPUnit_Framework_TestCase;
use Vinala\Kernel\Foundation\Application;


/**
* TestCase Class For testing
*/
class TestCase_ extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * Run the test
	 */
	public function run()
	{
		self::call();
		//
		return self::mock();
	}

	/**
	 * Call the Lighty Framework
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
		return Application::runTest("",$path,false,false,true);
	}

	/**
	 * Check if App Class retruns true
	 */
	public static function mock()
	{
		return self::instance(__DIR__."/../");
	}
}

