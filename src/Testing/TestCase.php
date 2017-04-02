<?php

namespace Vinala\Kernel\Testing ;

use PHPUnit\Framework\TestCase as BaseTestCase;

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
    public function isEquals($actual , $expected)
    {
        $this->assertEquals( $expected , $actual );
    }

}