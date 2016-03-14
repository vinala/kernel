<?php 


use Fiesta\Kernel\Testing\TestCase;

/**
* AppTestClass for testing
*/
class RouteTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Check if PHPUnit accept the Framework test 
	 */
	public function testGetRoute()
	{
		require_once __DIR__.'/../../src/Testing/TestCase.php';
		// //
		TestCase::run();
		$rrr=!true;
		
		return $this->assertTrue( $rrr );
	}
}


// get($uri,$callback,$subdomains=null)