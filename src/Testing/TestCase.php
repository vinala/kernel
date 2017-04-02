<?php

namespace Vinala\Kernel\Testing ;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Vinala\Kernel\Foundation\Application;

/**
* The TestCase class
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Testing
* @since v3.3.0
*/
class TestCase extends BaseTestCase
{
    /**
    * Check if two given values is the same
    *
    * @param mixed $actual
    * @param mixed $expected
    * @return bool
    */
    public function equals($actual , $expected)
    {
        $this->assertEquals( $expected , $actual );
    }

    /**
    * Check if given value is true
    *
    * @param mixed $actual
    * @return bool
    */
    public function true($actual , $message = '')
    {
        $this->assertTrue($actual , $message);
    }

}