<?php

namespace Vinala\Kernel\Foundation ;

use Vinala\Kernel\Http\Input;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Maintenance\Maintenance;
use Vinala\Kernel\Logging\Log;
use Vinala\Kernel\Logging\Handler;
use Vinala\Kernel\Storage\Session;
use Vinala\Kernel\Validation\Validator;
use Vinala\Kernel\Foundation\Component;

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

        //Time Surface
        static::time();

        //Initiate the Logging Surface
        static::initLogging();

        //Component Surface
        static::component();

        //Cubes Surface
        static::cubes();

        //Collections Surface
        static::collections();

        //Storage Surface
        static::storage($session);

        //Strings Surface
        static::strings();

        //Access Surface
        static::access();

        //Validation Surface
        static::validation();

        //Call Faker Surface if enabled in Component surface
        if(Component::isOn("faker"))
        {
            static::faker();
        }
        
        //Cookie Surface
        static::cookie();

        //Router Surface
        static::router();

        //Caches Surface
        static::caches();

        //Security Surface
        static::security();

        //Auth Surface
        static::auth();

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

    /**
    * Call Time surface
    *
    * @return numm
    */
    private static function time()
    {
        $files = ['DateTime'];
        $folder  = self::$path.'Objects'.'/'; // to do : cahnge the folder

        self::call($files , $folder);
    }

    /**
    * Init Logging surface
    *   
    * @return null
    */
    private static function initLogging()
    {
        Log::ini();
		Handler::run();
    }

    /**
    * Call Component surface
    *
    * @return null
    */
    private static function component()
    {
        $files = ['Component'];
        $folder  = self::$path.'Foundation'.'/';

        self::call($files , $folder);
        //
        $files = ['SurfaceDisabledException'];
        $folder  = self::$path.'Foundation/Exceptions'.'/';

        self::call($files , $folder);
    }

    /**
    * Call Cubes surface
    *
    * @return null
    */
    private static function cubes()
    {
        $files = ['Cube','Accessor'];
        $folder  = self::$path.'Cubes'.'/';

        self::call($files , $folder);
    }

    /**
    * Call the Collections surface
    *
    * @return null
    */
    private static function collections()
    {
        $files = ['JSON','Collection'];
        $folder  = self::$path.'Collections'.'/';

        self::call($files , $folder);
    }

    /**
    * Call Session class
    *
    * @param bool $session
    * @return null
    */
    private static function session($session)
    {
        $files = ['Session'];
        $folder  = self::$path.'Storage'.'/';

        self::call($files , $folder);

        $files = ['SessionKeyNotFoundException' , 'SessionSurfaceIsOffException'];
        $folder  = self::$path.'Storage/Exceptions'.'/';

        self::call($files , $folder);

        //Initiat the class
        if($session) 
		{
			Session::ini();
		}
    }

    /**
    * Call the Storage surface
    *
    * @return null
    */
    private static function storage($seesion)
    {
        //Initiat the class
        static::session($session);

        $files = ['Storage'];
        $folder  = self::$path.'Storage'.'/';

        self::call($files , $folder);

        $files = ['NotFoundStorageDiskException'];
        $folder  = self::$path.'Storage/Exceptions'.'/';

        self::call($files , $folder);
    }

    /**
    * Call the String surface
    *
    * @return null
    */
    private static function string($seesion)
    {
        $files = ['Strings'];
        $folder  = self::$path.'Strings'.'/';

        self::call($files , $folder);

        $files = ['StringOutIndexException'];
        $folder  = self::$path.'Strings/Exceptions'.'/';

        self::call($files , $folder);
    }

    /**
    * Call the Access surface
    *
    * @return null
    */
    private static function access()
    {
        $files = ['Path' , 'Url'];
        $folder  = self::$path.'Access'.'/';

        self::call($files , $folder);
    }

    /**
    * Call the Validation surface
    *
    * @return null
    */
    private static function validation()
    {
        $files = ['Validator' , 'ValidationResultUrl'];
        $folder  = self::$path.'Validation'.'/';

        self::call($files , $folder);

        //Initiate the validation surface
        Validator::ini();
    }

    /**
    * Call the Faker surface
    *
    * @return null
    */
    private static function faker()
    {
        $files = ['Faker'];
        $folder  = self::$path.'Resources'.'/';

        self::call($files , $folder);
    }

    /**
    * Call Cookie surface
    *
    * @return null
    */
    private static function cookie()
    {
         $files = ['Cookie'];
        $folder  = self::$path.'Storage'.'/';

        self::call($files , $folder);
    }

    /**
    * Call Router surface
    *
    * @return null
    */
    private static function router()
    {
        $files = ['Url' , 'Routes' , 'Route'];
        $folder  = self::$path.'Router'.'/';

        self::call($files , $folder);

        $files = ['NotFoundHttpException'];
        $folder  = self::$path.'Router/Exceptions'.'/';

        self::call($files , $folder);
    }

    /**
    * Call Caches surface
    *
    * @return null
    */
    private static function caches()
    {
        $files = ['Driver', 'FileDriver', 'ArrayDriver','PhpFilesDriver','ApcDriver','PDODriver'];
        $folder  = self::$path.'Caches/Drivers'.'/';

        self::call($files , $folder);

        $files = ['Item', 'Cache', 'FileCache', 'DatabaseCache'];
        $folder  = self::$path.'Caches'.'/';

        self::call($files , $folder);

        $files = ['CacheItemNotFoundException', 'DriverNotFoundException', 'DatabaseSurfaceDisabledException'];
        $folder  = self::$path.'Caches/Exceptions'.'/';

        self::call($files , $folder);
    }

    /**
    * Call Securtiy surface
    *
    * @return null
    */
    private static function securtiy()
    {
        $files = ['Hash'];
        $folder  = self::$path.'Securtiy'.'/';

        self::call($files , $folder);
    }

    /**
    * Call Securtiy surface
    *
    * @return null
    */
    private static function auth()
    {
        $files = ['Auth'];
        $folder  = self::$path.'Authentication'.'/';

        self::call($files , $folder);

        $files = ['AuthenticationModelNotFoundException'];
        $folder  = self::$path.'Authentication/Exceptions'.'/';

        self::call($files , $folder);
    }

    



}