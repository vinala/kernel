<?php 

use Pikia\Kernel\Config\Config;

/**
* ConfigTest for testing
*/
class ConfigTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Test on App Config Params
	 */
	public function testAppConfigParams()
	{
		$this->assertEquals(Config::get("app.project"),"Pikia Kernel");
		$this->assertEquals(Config::get("app.timezone"),"UTC");
	}

	/**
	 * Test on Loggin Config Params
	 */
	public function testLogginConfigParams()
	{
		$this->assertEquals('app/storage/logs/pikia.log', Config::get("loggin.log"));
		$this->assertTrue( ! Config::get("loggin.debug"));
	}


}