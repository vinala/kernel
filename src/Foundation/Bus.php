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
use Vinala\Kernel\Atomium\Compiler;
use Vinala\Kernel\Logging\Error;

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
    public static function run($type = 'web', $session = true)
    {
        $lumos = $type == 'lumos' ? true : false ;
        static::init($type);

        //Support Surface
        static::support();

        //Version Surface
        static::version();

        //Logging Surface
        static::logging();

        //Input Surface
        static::input();

        if ($type == 'test') {
            //Mock Surface
            static::mock();
        }

        //Config Surface
        static::config($type == 'test' ? true : false);

        //Environment Surface
        static::environment();

        //Maintenance Surface
        static::maintenance($lumos);

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
        static::string();

        //Access Surface
        static::access();

        //Validation Surface
        static::validation();

        //Call Faker Surface if enabled in Component surface
        if (Component::isOn("faker")) {
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

        //Call Database Surface if enabled in Component surface
        if (Component::isOn("database")) {
            static::database();
        }

        //HTTP Surface
        static::http();

        //Assets Surface
        static::assets();

        //HTML Surface
        static::html();

        //Hypertext Surface
        //Depracted
        static::Hypertext();

        //Translator Surface
        static::translator();

        //Model Surface
        static::model();

        //Relations Surface
        static::relations();

        //Media Surface
        static::media();

        //Views Surface
        static::view();

        //Controllers Surface
        static::controller();

        //Mail Surface
        static::mail();

        //Data Collection Surface
        static::dataCollection();

        //Files Surface
        static::file();

        //Intro Surface
        static::intro();

        //Plugins Surface
        static::plugins();

        //Lumos Surface
        static::lumos();

        //Atomium Surface
        static::atomium();

        //Proccess Surface
        static::proccess();

        //Setup Surface
        static::setup();

        //Events Surface
        static::event();

        //Tests Surface
        static::test();
    }

    /**
    * Initiate the framework in Web mode
    *
    * @param bool $test
    * @return string
    */
    private static function init($type)
    {
        switch ($type) {
            case 'test':
                    static::$root = 'src/';
                break;

            case 'web':
                    static::$root = root().'vendor/vinala/kernel/src/';
                break;

            case 'lumos':
                    static::$root = 'vendor/vinala/kernel/src/';
                break;
        }

        return static::$root;
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
        exception_if( ! file_exists($path), BusFileNotFoundException::class, $path);
        
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
        exception_if( ! file_exists($path), BusFileNotFoundException::class, $path);
        
        return include_once $path;
    }

    /**
    * Call files of a folder
    *
    * @param array $files
    * @param string $folder
    * @return null
    */
    private static function call(array $files, $folder, $ext = 'php')
    {
        foreach ($files as $file) {
            static::need($folder.$file.'.'.$ext);
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
        foreach ($files as $file) {
            static::need($files);
        }
    }

    /**
    * Fetch files from folder
    *
    * @param string $pattern
    * @param bool $app : if using app/files
    * @return array
    */
    public static function fetch($pattern, $app = false)
    {
        if ($app) {
            $path = root() . 'app/'.$pattern.'/*.php';
        } else {
            $path = root() .$pattern.'/*.php';
        }
        return glob($path);
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
        $folder  = static::$root.'Foundation'.'/';

        self::call($files, $folder);
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
        $folder  = static::$root.'Logging'.'/';

        self::call($files, $folder);
    }

    /**
    * Call and init Input surface
    *
    * @return null
    */
    private static function input()
    {
        $files = ['Input'];
        $folder  = static::$root.'Http'.'/';

        self::call($files, $folder);

        Input::register();
    }

    /**
    * Call the support surface
    *
    * @return null
    */
    private static function support()
    {
        require_once static::$root.'Support'.'/'.'FunctionArgs.php';
    }

    /**
    * Call Config surface and initiate it
    *
    * @return null
    */
    private static function config($test = false)
    {
        $files = ['Config' , 'Alias' ];
        $folder  = static::$root.'Config'.'/';

        self::call($files, $folder);
        //
        $files = ['ConfigException' , 'DatabaseDriverNotFoundException' , 'AliasedClassNotFoundException' ];
        $folder  = static::$root.'Config/Exceptions'.'/';

        self::call($files, $folder);
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
        $folder  = static::$root.'Environment'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Maintenance surface
    *
    * @return null
    */
    private static function maintenance($lumos)
    {
        $files = ['Maintenance'];
        $folder  = static::$root.'Maintenance'.'/';

        self::call($files, $folder);

        if (! $lumos) {
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
        $folder  = static::$root.'Objects'.'/'; // to do : cahnge the folder

        self::call($files, $folder);
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
        $folder  = static::$root.'Foundation'.'/';

        self::call($files, $folder);
        //
        $files = ['SurfaceDisabledException'];
        $folder  = static::$root.'Foundation/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call Cubes surface
    *
    * @return null
    */
    private static function cubes()
    {
        $files = ['Cube','Accessor'];
        $folder  = static::$root.'Cubes'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Collections surface
    *
    * @return null
    */
    private static function collections()
    {
        $files = ['JSON','Collection'];
        $folder  = static::$root.'Collections'.'/';

        self::call($files, $folder);
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
        $folder  = static::$root.'Storage'.'/';

        self::call($files, $folder);

        $files = ['SessionKeyNotFoundException' , 'SessionSurfaceIsOffException'];
        $folder  = static::$root.'Storage/Exceptions'.'/';

        self::call($files, $folder);

        //Initiat the class
        if ($session) {
            Session::ini();
        }
    }

    /**
    * Call the Storage surface
    *
    * @return null
    */
    private static function storage($session)
    {
        //Initiat the class
        static::session($session);

        $files = ['Storage'];
        $folder  = static::$root.'Storage'.'/';

        self::call($files, $folder);

        $files = ['NotFoundStorageDiskException'];
        $folder  = static::$root.'Storage/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the String surface
    *
    * @return null
    */
    private static function string()
    {
        $files = ['Strings'];
        $folder  = static::$root.'Strings'.'/';

        self::call($files, $folder);

        $files = ['StringOutIndexException'];
        $folder  = static::$root.'Strings/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Access surface
    *
    * @return null
    */
    private static function access()
    {
        $files = ['Path' , 'Url'];
        $folder  = static::$root.'Access'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Validation surface
    *
    * @return null
    */
    private static function validation()
    {
        $files = ['Validator' , 'ValidationResult'];
        $folder  = static::$root.'Validation'.'/';

        self::call($files, $folder);

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
        $folder  = static::$root.'Resources'.'/';

        self::call($files, $folder);
    }

    /**
    * Call Cookie surface
    *
    * @return null
    */
    private static function cookie()
    {
         $files = ['Cookie'];
        $folder  = static::$root.'Storage'.'/';

        self::call($files, $folder);
    }

    /**
    * Call Router surface
    *
    * @return null
    */
    private static function router()
    {
        $files = ['Url' , 'Routes' , 'Route'];
        $folder  = static::$root.'Router'.'/';

        self::call($files, $folder);

        $files = ['NotFoundHttpException'];
        $folder  = static::$root.'Router/Exceptions'.'/';

        self::call($files, $folder);

        //New router surface

        $files = ['Route' , 'Routes'];
        $folder  = static::$root.'Http/Router'.'/';

        self::call($files, $folder);

        $files = ['RouteDuplicatedException' , 'RouteMiddlewareNotFoundException'];
        $folder  = static::$root.'Http/Router/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call Caches surface
    *
    * @return null
    */
    private static function caches()
    {
        $files = ['Driver', 'FileDriver', 'ArrayDriver','PhpFilesDriver','ApcDriver','PDODriver'];
        $folder  = static::$root.'Caches/Drivers'.'/';

        self::call($files, $folder);

        $files = ['Item', 'Cache'];
        $folder  = static::$root.'Caches'.'/';

        self::call($files, $folder);

        $files = ['CacheItemNotFoundException', 'DriverNotFoundException', 'DatabaseSurfaceDisabledException'];
        $folder  = static::$root.'Caches/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call security surface
    *
    * @return null
    */
    private static function security()
    {
        $files = ['Hash'];
        $folder  = static::$root.'Security'.'/';

        self::call($files, $folder);
    }

    /**
    * Call Auth surface
    *
    * @return null
    */
    private static function auth()
    {
        $files = ['Auth'];
        $folder  = static::$root.'Authentication'.'/';

        self::call($files, $folder);

        $files = ['AuthenticationModelNotFoundException'];
        $folder  = static::$root.'Authentication/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call Database surface
    *
    * @return null
    */
    private static function database()
    {
        $path = static::$root.'Database/';

        //--------------------------------------------------------
        // Calling drivers
        //--------------------------------------------------------

        $files = ['Driver' , 'MysqlDriver'];
        $folder  = $path.'Drivers'.'/';

        self::call($files, $folder);

        //--------------------------------------------------------
        // Calling exporters
        //--------------------------------------------------------

        $files = ['MysqlExporter'];
        $folder  = $path.'Exporters'.'/';

        self::call($files, $folder);

        //--------------------------------------------------------
        // Calling Connectors
        //--------------------------------------------------------

        $files = ['MysqlConnector'];
        $folder  = $path.'Connectors'.'/';

        self::call($files, $folder);

        //--------------------------------------------------------
        // Calling Exceptions
        //--------------------------------------------------------

        $files = ['ConnectorException','QueryException','SeedersEmptyException','DatabaseArgumentsException', 'DatabaseConnectionException', 'SchemaTableExistsException','SchemaTableNotExistException'];
        $folder  = $path.'Exceptions'.'/';

        self::call($files, $folder);

        //--------------------------------------------------------
        // Calling Schemas
        //--------------------------------------------------------

        $files = ['Schema','MysqlSchema'];
        $folder  = $path.'Schemas'.'/';

        self::call($files, $folder);

        //--------------------------------------------------------
        // Calling Database parts
        //--------------------------------------------------------

        $files = ['Migration', 'Seeder', 'DBTable','Query', 'Row', 'Database'];
        $folder  = $path;

        self::call($files, $folder);
    }

    /**
    * Call HTTP surface
    *
    * @return null
    */
    private static function http()
    {
        $files = ['Http','Request'];
        $folder  = static::$root.'Http'.'/';

        self::call($files, $folder);

        static::links();
        static::redirect();
        static::middleware();
    }

    /**
    * Call the Links surface
    *
    * @return null
    */
    private static function links()
    {
        $files = ['Link'];
        $folder  = static::$root.'Http/Links'.'/';

        self::call($files, $folder);

        $files = ['LinkKeyNotFoundException'];
        $folder  = static::$root.'Http/Links/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Redirection surface
    *
    * @return null
    */
    private static function redirect()
    {
        $files = ['Redirector' , 'Redirect'];
        $folder  = static::$root.'Http/Redirect'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Middleware surface
    *
    * @return null
    */
    private static function middleware()
    {
        $files = ['Filters','Middleware'];
        $folder  = static::$root.'Http/Middleware'.'/';

        self::call($files, $folder);

        $files = ['MiddlewareNotFoundException', 'MiddlewareWallException'];
        $folder  = static::$root.'Http/Middleware/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Assets surface
    *
    * @return null
    */
    private static function assets()
    {
        $files = ['Assets'];
        $folder  = static::$root.'Resources'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Html surface
    *
    * @return null
    */
    private static function html()
    {
        $files = ['Html' , 'Form'];
        $folder  = static::$root.'Html'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Hypertext surface
    *
    * @depracted v3.3.0
    * @return null
    */
    private static function hypertext()
    {
        $files = ['Res' , 'HTML'];
        $folder  = static::$root.'Hypertext'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Translator surface
    *
    * @return null
    */
    private static function translator()
    {
        $files = ['Lang', 'Smiley'];
        $folder  = static::$root.'Translator'.'/';

        self::call($files, $folder);

        $files = ['LanguageKeyNotFoundException', 'LanguageNotSupportedException'];
        $folder  = static::$root.'Translator/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Model surface
    *
    * @return null
    */
    private static function model()
    {
        $files = ['ORM_','CRUD','ORM','Collection','ModelArray'];
        $folder  = static::$root.'MVC/Model'.'/';

        self::call($files, $folder);

        $files = ['ForeingKeyMethodException', 'ColumnNotEmptyException', 'ManyPrimaryKeysException', 'TableNotFoundException','ModelNotFoundException','PrimaryKeyNotFoundException'];
        $folder  = static::$root.'MVC/Model/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Realtons surface
    *
    * @return null
    */
    private static function relations()
    {
        $files = ['OneToOne', 'OneToMany', 'ManyToMany', 'BelongsTo'];
        $folder  = static::$root.'MVC/Relations'.'/';

        self::call($files, $folder);

        $files = ['ManyRelationException', 'ModelNotFindedException'];
        $folder  = static::$root.'MVC/Relations/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Media surface
    *
    * @return null
    */
    private static function media()
    {
        $files = ['QR'];
        $folder  = static::$root.'Media'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the View surface
    *
    * @return null
    */
    private static function view()
    {
        $files = ['View'];
        $folder  = static::$root.'MVC/View'.'/';

        self::call($files, $folder);

        $files = ['Template' , 'Views'];
        $folder  = static::$root.'MVC/View/Libs'.'/';

        self::call($files, $folder);

        $files = ['ViewNotFoundException'];
        $folder  = static::$root.'MVC/View/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Controllers surface
    *
    * @return null
    */
    private static function controller()
    {
        $files = ['Controller'];
        $folder  = static::$root.'MVC'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Mail surface
    *
    * @return null
    */
    private static function mail()
    {
        $files = ['Mail'];
        $folder  = static::$root.'Mailing'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Data Collection surface
    *
    * @return null
    */
    private static function dataCollection()
    {
        $files = ['DataCollection'];
        $folder  = static::$root.'Objects'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Files surface
    *
    * @return null
    */
    private static function file()
    {
        $files = ['File' , 'Filesystem'];
        $folder  = static::$root.'Filesystem'.'/';

        self::call($files, $folder);

        $files = ['FileNotFoundException', 'DirectoryNotFoundException'];
        $folder  = static::$root.'Filesystem/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Intro surface
    *
    * @return null
    */
    private static function intro()
    {
        $files = ['Intro'];
        $folder  = static::$root.'Access'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Plugins surface
    *
    * @return null
    */
    private static function plugins()
    {
        $files = ['Plugins'];
        $folder  = static::$root.'Plugins'.'/';

        self::call($files, $folder);

        $files = ['AutoloadFileNotFound' , 'InfoStructureException'];
        $folder  = static::$root.'Plugins/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Lumos surface
    *
    * @return null
    */
    private static function lumos()
    {
        $files = ['cmdOutput', 'bashOutput', 'Argument', 'Option', 'Command'];
        $folder  = static::$root.'Lumos'.'/';

        self::call($files, $folder);

        // Call Kernel commands
        static::commands();

        $files = ['Console'];
        $folder  = static::$root.'Lumos'.'/';

        self::call($files, $folder);

        $files = ['ConfigSetting'];
        $folder  = static::$root.'Lumos/Response'.'/';

        self::call($files, $folder);
    }

    /**
    * Require commands of Lumos
    *
    * @return null
    */
    private static function commands()
    {
        foreach (self::fetch(static::$root."Lumos/Commands") as $file) {
            static::need($file);
        }
    }

    /**
    * Call the Atomium surface
    *
    * @return null
    */
    private static function atomium()
    {
        $path = static::$root.'Atomium/';

        $files = ['Atomium', 'Compiler'];
        $folder  = $path;

        self::call($files, $folder);

        $files = [
                    'AtomiumUserTags',
                    //
                    'AtomiumCompileCSS','AtomiumCompileJS','AtomiumCompileAssign','AtomiumCompileRun',
                    //
                    'AtomiumCompileComments','AtomiumCompileComment',
                    //
                    'AtomiumCompileInstruction','AtomiumCompileInstructions','AtomiumCompileIf','AtomiumCompileFor','AtomiumCompileEndFor','AtomiumCompileBreak','AtomiumCompileOneLineComment','AtomiumCompileElse','AtomiumCompileEndIf','AtomiumCompileElseIf','AtomiumCompileForeach','AtomiumCompileEndForeach','AtomiumCompileWhile','AtomiumCompileEndWhile','AtomiumCompileUntil','AtomiumCompileEndUntil','AtomiumCompileSub','AtomiumCompileExec',
                    //
                    'AtomiumCompileLang',
                    //
                    'AtomiumCompileTake','AtomiumCompileCapture'
                ];
        $folder  = $path.'Compiler'.'/';

        self::call($files, $folder);

        $files = ['AromiumCaptureNotFoundException'];
        $folder  = $path.'Exception/';

        self::call($files, $folder);

        Compiler::setUserTags();
    }

    /**
    * Call the Process surface
    *
    * @return null
    */
    private static function proccess()
    {
        $files = ['Command', 'Process', 'Translator', 'Schema', 'Links', 'Tag', 'Model', 'View', 'Controller', 'Seeds', 'Routes', 'Exception', 'Events', 'Alias','Middleware','Helper','Tests'];
        $folder  = static::$root.'Processes'.'/';

        self::call($files, $folder);

        $files = ['TranslatorFolderNeededException', 'TranslatorManyFolderException'];
        $folder  = static::$root.'Processes/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Setup surface
    *
    * @return null
    */
    private static function setup()
    {
        $files = ['Routes', 'Setup', 'Response'];
        $folder  = static::$root.'Setup'.'/';

        self::call($files, $folder);

        $files = ['Database', 'Panel', 'Security', 'Maintenance', 'Loggin', 'Translator', 'App', 'Robots'];
        $folder  = static::$root.'Setup/Documentations'.'/';

        self::call($files, $folder);

        $files = ['AppSetupException'];
        $folder  = static::$root.'Setup/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Event surface
    *
    * @return null
    */
    private static function event()
    {
        $files = ['Event', 'EventListener'];
        $folder  = static::$root.'Event'.'/';

        self::call($files, $folder);

        $files = ['ManyListenersArgumentsException'];
        $folder  = static::$root.'Event/Exceptions'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Mocking surface
    *
    * @return null
    */
    private static function mock()
    {
        $files = ['configMocking'];
        $folder  = static::$root.'Mocking'.'/';

        self::call($files, $folder);
    }

    /**
    * Call the Tests surface
    *
    * @return null
    */
    private static function test()
    {
        $files = ['TestCase'];
        $folder  = static::$root.'Testing'.'/';

        self::call($files, $folder);
    }
}
