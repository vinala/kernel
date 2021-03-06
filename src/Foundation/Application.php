<?php

namespace Vinala\Kernel\Foundation;

use Vinala\Kernel\Access\Path;
use Vinala\Kernel\Access\Url;
use Vinala\Kernel\Authentication\Auth;
use Vinala\Kernel\Config\Alias;
use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Database\Schema;
use Vinala\Kernel\Http\Links\Link;
use Vinala\Kernel\MVC\View\Template;
use Vinala\Kernel\Plugins\Plugins;
use Vinala\Kernel\Resources\Faker;
use Vinala\Kernel\Storage\Cookie;
use Vinala\Kernel\Translator\Lang;

class Application
{
    public static $page;
    public static $root;
    public static $Callbacks = ['before'=>null, 'after'=>null];

    /**
     * For Route path to not to use $root.
     *
     * @var string
     */
    public static $path;

    /**
     * True if the framework in test case.
     *
     * @var bool
     */
    public static $isTest;

    /**
     * True if the framework use console.
     *
     * @var bool
     */
    public static $isConsole = false;

    /**
     * The framework version info.
     *
     * @var array
     */
    protected static $version = null;

    /**
     * The result of test.
     *
     * @var array
     */
    protected static $test = false;

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Set the framework version.
     *
     * @return array
     */
    public static function setVersion()
    {
        self::$version = instance(Version::class);
    }

    /**
     * Get the framework version.
     *
     * @return array
     */
    public static function getVersion()
    {
        return self::$version;
    }

    protected static function callBus($test = false)
    {
        require($test ? '' : root().'vendor/vinala/kernel/').'src/Foundation/Bus.php';
        require($test ? '' : root().'vendor/vinala/kernel/').'src/Foundation/Exceptions/BusFileNotFoundException.php';
    }

    /**
     * Using Connector in console.
     */
    protected static function consoleBus()
    {
        require 'vendor/vinala/kernel/src/Foundation/Bus.php';
        require 'vendor/vinala/kernel/src/Foundation/Exceptions/BusFileNotFoundException.php';
    }

    /**
     * Set the root of the framework for basic path.
     *
     * @param $root string
     */
    protected static function setRoot($root)
    {
        self::$root = $root;

        return $root;
    }

    /**
     * start recording the output to screen.
     */
    protected static function setScreen()
    {
        ob_start();
    }

    public static function setCaseVars($isConsole, $isTest)
    {
        self::$isConsole = $isConsole;
        self::$isTest = $isTest;
    }

    /**
     * Run the Framework.
     */
    public static function run($root = '../', $routes = true, $session = true)
    {
        self::setScreen();
        self::setRoot($root);
        //
        self::setCaseVars(false, false);

        // call the connector and run it
        self::callBus();
        // Connector::run('web',$session);
        Bus::run('web', $session);
        self::setVersion();
        // set version cookie for Wappalyzer
        self::$version->cookie();
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
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '';
    }

    /**
     * Run the console.
     */
    public static function console($root = '', $session = true)
    {
        self::setCaseVars(true, false);
        //
        self::consoleServerVars();
        //
        self::setScreen();
        self::setRoot($root);
        // call the connector and run it
        self::consoleBus();
        Bus::run('lumos');

        self::setVersion();
        //
        self::ini(false);
        //
        self::fetcher(false);
        //
        return true;
    }

    /**
     * Run the Framework.
     */
    public static function runTest($root = '../', $routes = true, $session = false)
    {
        self::setScreen();
        self::setRoot($root);
        //
        self::$isTest = true;

        // call the connector and run it
        self::callBus();
        Bus::run('test', $session);

        self::setVersion();

        // set version cookie for Wappalyzer
        //
        self::ini(true, true);
        //
        self::fetcher($routes);
        //
        return true;
    }

    /**
     * Init Framework classes.
     */
    protected static function ini($database = true, $test = false)
    {
        Alias::ini(self::$root);
        Url::ini();
        Path::ini();
        Template::run();
        if (Component::isOn('faker')) {
            Faker::ini();
        }
        Link::ini();
        Lang::ini($test);
        if ($database && Component::isOn('database')) {
            Database::ini();
            Schema::ini();
        }
        Auth::ini();
        Plugins::ini();
    }

    /**
     * Calling the fetcher.
     */
    protected static function fetcher($routes)
    {
        Bus::need(self::$root.'vendor/vinala/kernel/src/Foundation/Fetcher.php');
        Fetcher::run($routes);
    }

    /**
     * call vendor.
     */
    public static function vendor()
    {
        self::checkVendor();
        $path = is_null(self::$root) ? 'vendor/autoload.php' : self::$root.'vendor/autoload.php';
        include_once $path;
    }

    public static function before($fun)
    {
        self::$Callbacks['before'] = $fun;
    }

    public static function after($fun)
    {
        self::$Callbacks['after'] = $fun;
    }

    public static function root()
    {
        $sub = $_SERVER['PHP_SELF'];
        $r = explode('App.php', $sub);
        //
        // $host = (isset($_SERVER["HTTP_HOST"]) && ! empty()) ? "localhost"
        return 'http://'.$_SERVER['HTTP_HOST'].$r[0];
    }

    public static function test()
    {
        self::setScreen();
        self::setRoot('../');
        // //
        self::$isTest = true;
        // // call the connector and run it

        self::callBus(true);
        Bus::run('test');

        // //
        // self::ini();
        // //
        // self::fetcher($routes);
        //

        self::$test = true;

        return true;
    }

    /**
     * Set SHA Code.
     */
    public static function setSHA()
    {
        $SHA = '97e88f56e4dd302eeac7a7cb0367f966f1adaa815ba77be2b410132d4768bfbd';
        Cookie::create('sha256', $SHA, 3);
    }

    /**
     * Get the result of the test.
     *
     * @return bool
     */
    public static function getTestResult()
    {
        return static::$test;
    }
}
