<?php

namespace Vinala\Kernel\Logging;

use Vinala\Kernel\Config\Config;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Error Handler class.
 */
class Handler
{
    /**
     * the class whoops.
     */
    protected static $whoops;

    /**
     * the page of hundler.
     */
    protected static $page;

    public static function run()
    {
        if (Config::get('loggin.debug')) {
            self::PrettyPage();
        } else {
            self::SimplePage();
        }
        //
        self::setDebug();
    }

    /**
     * Set Kint.
     *
     * @return null
     */
    protected static function setDebug()
    {
        // \Kint::$theme = 'solarized-dark';
        \Kint::$theme = 'dark';
    }

    protected static function PrettyPage()
    {
        self::$whoops = new Run();
        self::$page = new PrettyPageHandler();
        //
        self::setPrettyParams();
        self::exec();
    }

    protected static function SimplePage()
    {
        self::$whoops = new Run();
        self::$page = new PlainTextHandler();
        //
        self::setSimpleParams();
        self::exec();
    }

    protected static function setPrettyParams()
    {
        self::$page->setEditor('sublime');
    }

    protected static function setSimpleParams()
    {
        self::$page->handle();
    }

    protected static function exec()
    {
        self::$whoops->pushHandler(self::$page);
        self::$whoops->register();
    }
}
