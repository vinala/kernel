<?php 

use Pikia\Kernel\Config\Config;

/**
* ConfigTest for testing
*/
class ConfigTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Test on load Config params
	 */
	public function testConfigParams()
	{
		// Loggin
		$this->assertEquals('app/storage/logs/pikia.log', Config::get("loggin.log"));
		$this->assertTrue( ! Config::get("loggin.debug"));
		//
		return true;
	}
}