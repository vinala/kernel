<?php

namespace Vinala\Kernel\Foundation ;

use Vinala\Kernel\Http\Input;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Maintenance\Maintenance;

use Vinala\Kernel\Foundation\Exception\BusFileNotFoundException;

/**
* The surface responsible of connecting all framework surfaces
*
* @version 2.0 
* @author Youssef Had
* @package Vinala\Kernel\Foundation
* @since v3.3.0
*/
class Bus
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
    * The root Kernel path     
    *
    * @var string
    */
    private static $root;

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * Run the Bus surface
    *
    * @param bool $lumos
    * @param bool $session
    * @return null
    */
    public static function run($lumos = false , $session = true)
    {
        static::init(($lumos) ? 'lumos' : 'web');

        //Version Surface
        static::version();

        //Logging Surface
        static::logging();

        //Input Surface
        static::input();
        
        //Support Surface
        static::support();

        //Environment Surface
        static::environment();

    }

    /**
    * Initiate the framework in Web mode 
    *
    * @param bool $test
    * @return string
    */
    private static function init($test)
    {
        switch ($type) {
            case 'test':
                    self::$path = 'src/';
                break;

            case 'web':
                    self::$path = root().'vendor/vinala/kernel/src/';
                break;

            case 'lumos':
                    self::$path = 'vendor/vinala/kernel/src/';
                break;
        }

        return self::$path;
    }
    
    //--------------------------------------------------------
    // File calling functions
    //--------------------------------------------------------

    /**
    * Require files 
    *
    * @param string $path 
    * @return null
    */
    public static function need($path)
    {
        exception_if( ! file_exists($path) , BusFileNotFoundException::class , $path);
        
        return require $path;
    }

    /**
    * Require files once
    *
    * @param string $path 
    * @return null
    */
    public static function needOnce($path)
    {
        exception_if( ! file_exists($path) , BusFileNotFoundException::class , $path);
        
        return include_once $path;
    }

    /**
    * Call files of a folder
    *
    * @param array $files 
    * @param string $folder
    * @return null
    */
    private static function call(array $files , $folder , $ext = 'php')
    {
        foreach ($files as $file) 
        {
            static::need($path.$file.'.'.$ext);
        }
    }

    /**
    * Call files with full path 
    *
    * @param array $files
    * @return null
    */
    public static function using(array $files)
    {
        foreach ($files as $file) 
        {
            static::need($files);
        }
    }

    //--------------------------------------------------------
    // Calling the framework surfaces
    //--------------------------------------------------------

    /**
    * call version surface
    * surface namespace is Vinala\Kernel\Foundation\Version
    *
    * @return null
    */
    private static function version()
    {
        $files = ['Version'];
        $folder  = self::$path.'Foundation'.'/';

        self::call($files , $folder);
    }

    /**
    * Call logging surface
    * surface namespace is Vinala\Kernel\Logging
    *
    * @return null
    */
    private static function logging()
    {
        $files = ['Handler' , 'Exception' , 'Log'];
        $folder  = self::$path.'Logging'.'/';

        self::call($files , $folder);
    }

    /**
    * Call and init Input surface
    *
    * @return null
    */
    private static function input()
    {
        $files = ['Input'];
        $folder  = self::$path.'Http'.'/';

        self::call($files , $folder);

        Input::register();
    }

    /**
    * Call the support surface
    *
    * @return null
    */
    private static function support()
    {
        $files = ['FunctionArgs'];
        $folder  = self::$path.'Support'.'/';

        self::call($files , $folder);
    }

    /**
    * Call Config surface and initiate it 
    *
    * @return null
    */
    private static function config()
    {
        $files = ['Config' , 'Alias' ];
        $folder  = self::$path.'Config'.'/';

        self::call($files , $folder);
        //
        $files = ['ConfigException' , 'DatabaseDriverNotFoundException' , 'AliasedClassNotFoundException' ];
        $folder  = self::$path.'Config/Exceptions'.'/';

        self::call($files , $folder);
        //
        Config::load();
    }

    /**
    * Call Environment surface
    *
    * @return null
    */
    private static function environment()
    {
        $files = ['Environment'];
        $folder  = self::$path.'Environment'.'/';

        self::call($files , $folder);
    }

    /**
    * Call the Maintenance surface
    *
    * @return null
    */
    private static function maintenance($lumos)
    {
        $files = ['Maintenance'];
        $folder  = self::$path.'Maintenance'.'/';

        self::call($files , $folder);

        if( ! $lumos )
		{
			Maintenance::launch();	
		}
    }   

}