<?php

namespace Vinala\Kernel\Testing;

use Vinala\Kernel\Foundation\Application;

/**
 * TestCase Class For testing.
 */
class TestCase_old extends \PHPUnit_Framework_TestCase
{
    /**
     * Run the test.
     */
    public function run()
    {
        self::call();
        //
        return self::mock();
    }

    /**
     * Call the Vinala Framework.
     */
    public static function call()
    {
        require_once __DIR__.'/../Foundation/Application.php';
    }

    /**
     * Return instance the Framework App Class.
     */
    public static function instance($path)
    {
        return Application::runTest('', $path, false, false, true);
    }

    /**
     * Check if App Class retruns true.
     */
    public static function mock()
    {
        return self::instance(__DIR__.'/../');
    }
}
