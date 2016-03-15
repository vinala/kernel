<?php 

use Fiesta\Kernel\Config\Config;

/**
* ConfigTest for testing
*/
class ConfigTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Test on load Config params
	 */
	public function testLoadConfig()
	{
		$ret = Config::load();
		//
		return $this->assertTrue( $ret );
	}
}