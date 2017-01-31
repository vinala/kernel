<?php 

namespace Vinala\Kernel\Foundation;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Logging\Log;
use Vinala\Kernel\Logging\Handler;
use Vinala\Kernel\Logging\Error;
use Vinala\Kernel\Foundation\Exception\ConnectorFileNotFoundException as CFNFE;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Foundation\Component;
use Vinala\Kernel\Storage\Session;
use Vinala\Kernel\Atomium\Compiler;
use Vinala\Kernel\Http\Input;
use Vinala\Kernel\Validation\Validator;
use Vinala\Kernel\Maintenance\Maintenance;


/**
* Connector class to call framework core files
*/
class Connector
{
	/**
	 * Root Kernel path
	 */
	public static $path;


	/**
	 * Run the Connector class
	 */
	public static function run($lumos = false, $session = true)
	{
		if( ! $lumos) Connector::ini();
		else Connector::inilumos();

		// Version
		Connector::version();

		//**/
		Connector::loggin();
		Connector::input();
		Input::register();

		//Support
		Connector::support();

		// Config
		Connector::config();
		Config::load();
		Connector::maintenance($lumos);
		//
		Connector::time();
		//
		Log::ini();
		Handler::run();
		//
		Connector::component();
		Connector::cubes();
		//
		Connector::storage($session);
		Connector::collections();
		Connector::string();
		Connector::object();
		Connector::access();
		Connector::validation();
		if(Component::isOn("faker")) Connector::faker();
		Connector::cookie();
		Connector::router();
		Connector::caches();
		Connector::security();
		Connector::table();
		if(Component::isOn("database")) Connector::database();
		Connector::object_scnd();
		Connector::http();
		Connector::assets();
		Connector::Html();
		Connector::hypertext();
		Connector::translator();
		Connector::model();
		Connector::relations();
		Connector::media();
		Connector::view();
		Connector::controller();
		Connector::mail();
		Connector::dataCollection();
		Connector::fileSystem();
		Connector::intro();
		Connector::plugins();
		Connector::lumos();
		Connector::atomium();
		Connector::process();
		Connector::setup();
		Connector::event();
	}

	/**
	 * Init Connector class
	 */
	public static function ini($test = false)
	{
		self::$path = $test ? "src/" : Application::$root."vendor/vinala/kernel/src/";
		return self::$path;
	}

	/**
	* Call the Vinala\Kernel\foundation\Version
	*
	* @return null
	*/
	public static function version()
	{
		self::call(
			array(
				'Version'
				),
			self::$path.'Foundation/'
			);
	}
	

	/**
	 * Init Connector class
	 */
	public static function inilumos()
	{
		// self::$path = $test ? "src/" : Application::$root."vendor/vinala/kernel/src/";
		self::$path = "vendor/vinala/kernel/src/";
		return self::$path;

	}

	/**
	 * Require files
	 * @param $path string
	 */
	public static function need($path)
	{
		if(file_exists($path)) return require $path;
		else throw new CFNFE($path);
	}

	/**
	 * Require files once
	 * @param $path string
	 */
	public static function needOnce($path)
	{
		if(file_exists($path)) return include_once $path;
		else throw new CFNFE($path);
	}

	/**
	 * Call files
	 * @param $files array
	 * @param $path string
	 */
	public static function call($files,$path)
	{
		foreach ($files as $file) self::need($path.$file.".php");
	}

	/**
	 * Call many files
	 * @param $files array
	 */
	public static function using($files)
	{
		foreach ($files as $file) self::need($file);
	}

	/**
	* Call support classes
	*/
	public static function support()
	{
		self::call(
			array(
				'FunctionArgs'
				),
			self::$path.'Support/'
			);
	}

	/**
	 * Config Core Files
	 **/
	public static function config()
	{
		self::call(
			array(
				'Config', 
				'Alias'
				),
			self::$path.'Config/'
			);
		//
		self::call(
			array(
				'ConfigException', 
				'AliasedClassNotFoundException'
				),
			self::$path.'Config/Exceptions/'
			);
	}

	/**
	 * call vendor
	 */
	public static function vendor()
	{
		self::checkVendor();
		$path = is_null(Application::$root) ? '../vendor/autoload.php' : Application::$root.'vendor/autoload.php';
		include_once $path;
	}

	/**
	 * check if vendor existe
	 */
	public static function checkVendor()
	{
	// if( ! file_exists('../vendor/autoload.php')) die("You should install Lighty dependencies by composer commande 'composer install' :)");
	}

	/**
	 * Component call
	 */
	public static function component()
	{
		self::need(self::$path.'Foundation/Component.php');
	}

	/**
	 * Cubes call
	 */
	public static function cubes()
	{
		self::need(self::$path.'Cubes/Cube.php');
		self::need(self::$path.'Cubes/Accessor.php');
	}

	/**
	 * time call
	 */
	public static function time()
	{
		self::need(self::$path.'Objects/DateTime.php');
	}

	/**
	 * session call
	 */
	public static function session($session)
	{
		self::need(self::$path.'Storage/Session.php');
		if($session) Session::start();
	}

	/**
	 * storage call
	 */
	public static function storage($session = false)
	{
		self::session($session);
		self::need(self::$path.'Storage/Storage.php');
	}

	/**
	 * maintenance call
	 */
	public static function maintenance($lumos)
	{
		self::need(self::$path.'Maintenance/Maintenance.php');
		if( ! $lumos )
		{
			Maintenance::launch();	
		}
		
	}

	/**
	 * mail call
	 */
	public static function mail()
	{
		self::need(self::$path.'Mailing/Mail.php');
	}

	/**
	 * loggin call
	 */
	public static function loggin()
	{
		self::call(
			array(
				'Handler', 
				'Exception', 
				'Log'
				),
			self::$path.'Logging/'
			);
	}

	/**
	* A call to Vinala\Kernel\collections namesapce classes
	*
	* @return null
	*/
	public static function collections()
	{
		self::call(
			array(
				'JSON',
				),
			self::$path.'Collections/'
			);
	}
	

	/**
	 * string calls
	 */
	public static function string()
	{
		$path = self::$path.'Objects/Strings/';
		//
		self::need($path.'Strings.php');
		self::need($path.'Exceptions/StringOutIndexException.php');
	}

	/**
	 * object calls
	 */
	public static function object()
	{
		$files = array('Vars');
		$filesPath = self::$path.'Objects/';
		self::call($files,$filesPath);
	}

	/**
	 * object calls
	 */
	public static function object_scnd()
	{
		$files = array('Sys','Base');
		$filesPath = self::$path.'Objects/';
		self::call($files,$filesPath);
	}

	/**
	 * Access calls
	 */
	public static function access()
	{
		$files = array('Path','Url');
		$filesPath = self::$path.'Access/';
		self::call($files,$filesPath);
	}

	/**
	 * faker calls
	 */
	public static function faker()
	{
		self::need(self::$path.'Resources/Faker.php');
	}

	/**
	 * cookie calls
	 */
	public static function cookie()
	{
		self::need(self::$path.'Storage/Cookie.php');
	}

	/**
	 * Router calls
	 */
	public static function router()
	{
		self::call(
			array(
				'Url',
				'Routes', 
				'Route'
				),
			self::$path.'Router/'
			);
		//
		self::need(self::$path.'Router/Exceptions/NotFoundHttpException.php');
	}

	/**
	 * caches calls
	 */
	public static function caches()
	{
		self::call(
			array(
				'Caches', 
				'Cache', 
				'FileCache', 
				'DatabaseCache'
				),
			self::$path.'Caches/'
			);
		//
		self::need(self::$path.'Caches/Exceptions/DriverNotFoundException.php');
	}

	/**
	 * security calls
	 */
	public static function security()
	{
		self::call(
			array(
				'Auth',
				'Encrypt',
				'Security',
				'License'
				),
			self::$path.'Security/'
			);
	}

	/**
	 * table calls
	 */
	public static function table()
	{
		self::need(self::$path.'Objects/Table.php');
	}

	/**
	 * database calls
	 */
	public static function database()
	{

		//--------------------------------------------------------
		// Calling drivers
		//--------------------------------------------------------
		self::call(
			array(
				'Driver', 
				'MysqlDriver', 
				),
			self::$path.'Database/Drivers/'
			);

		//--------------------------------------------------------
		// Calling exporters
		//--------------------------------------------------------
		self::call(
			array(
				'MysqlExporter', 
				),
			self::$path.'Database/Exporters/'
			);

		//--------------------------------------------------------
		// Calling connectors
		//--------------------------------------------------------
		self::call(
			array(
				'MysqlConnector', 
				),
			self::$path.'Database/Connectors/'
			);
		
		//--------------------------------------------------------
		// Calling Exceptions
		//--------------------------------------------------------
		self::call(
			array(
				'ConnectorException',
				'QueryException',
				'SeedersEmptyException',
				'DatabaseArgumentsException', 
				'DatabaseConnectionException', 
				'SchemaTableExistsException',
				'SchemaTableNotExistException'
				),
			self::$path.'Database/Exceptions/'
			);

		//--------------------------------------------------------
		// Calling Schemas
		//--------------------------------------------------------
		self::call(
			array(
				'Schema',
				'MysqlSchema',
				
				),
			self::$path.'Database/Schemas/'
			);

		//--------------------------------------------------------
		// Calling Database parts
		//--------------------------------------------------------
		self::call(
			array(
				'Migration', 
				'Seeder', 
				'DBTable',
				'Query', 
				'Row', 
				'Database'
				),
			self::$path.'Database/'
			);
	}

	/**
	 * http calls
	 */
	public static function http()
	{
		self::call(
			array(
				'Http',
				'Request',
				),
			self::$path.'Http/'
			);

		self::links();
		self::redirect();
		self::middleware();
	}

	/**
	* Call the links surface
	*
	* @return null
	*/
	public static function links()
	{
		//Class calls
		self::call(
			array(
				'Link',
				),
			self::$path.'Http/Links/'
			);

		//Exceptions calls
		self::call(
			array(
				'LinkKeyNotFoundException',
				),
			self::$path.'Http/Links/Exceptions/'
			);
	}
	

	/**
	* Redirect calls
	*
	* @return null
	*/
	public static function redirect()
	{
		// Classes calls
		self::call(
			array(
				'Redirector',
				'Redirect'
				),
			self::$path.'Http/Redirect/'
			);
	}
	

	/**
	* Middleware calls
	*
	* @return null
	*/
	public static function middleware()
	{
		// Classes calls
		self::call(
			array(
				'Filters',
				'Middleware',
				),
			self::$path.'Http/Middleware/'
			);

		//Exceptions calls
		self::call(
			array(
				'MiddlewareNotFoundException',
				'MiddlewareWallException',
				),
			self::$path.'Http/Middleware/Exceptions/'
			);
	}
	

	/**
	* http input calls
	*
	*/
	public static function input()
	{
		self::call(
			array(
				'Input'
				),
			self::$path.'Http/'
			);
	}
	

	/**
	 * assets calls
	 */
	public static function assets()
	{
		self::need(self::$path.'Resources/Assets.php');
	}

	/**
	* call Vinala\Kernel\Html namespace
	*
	* @return null
	*/
	public static function Html()
	{
		self::call(
			array(
				'Html',
				'Form'
				),
			self::$path.'Html/'
			);
		return ;
	}
	

	/**
	 * hypertext calls
	 */
	public static function hypertext()
	{
		self::call(
			array(
				'Res',
				'HTML'
				),
			self::$path.'Hypertext/'
			);
	}

	/**
	 * translator calls
	 */
	public static function translator()
	{
		self::call(
			array(
				'Lang',
				'Smiley'
				),
			self::$path.'Translator/'
			);
		//
		self::need(self::$path.'Translator/Exceptions/LanguageKeyNotFoundException.php');
		self::need(self::$path.'Translator/Exceptions/LanguageNotSupportedException.php');
		
	}

	/**
	 * model calls
	 */
	public static function model()
	{
		self::call(
			array(
				'ORM_',
				'CRUD',
				'ORM',
				'Collection',
				'ModelArray'
				),
			self::$path.'MVC/Model/'
			);
		//
		self::call(
			array(
				'ForeingKeyMethodException', 
				'ColumnNotEmptyException', 
				'ManyPrimaryKeysException', 
				'TableNotFoundException',
				'ModelNotFoundException',
				'PrimaryKeyNotFoundException'
				),
			self::$path.'MVC/Model/Exceptions/'
			);
	}

	/**
	 * model calls
	 */
	public static function relations()
	{
		self::call(
			array(
				'OneToOne', 
				'OneToMany', 
				'ManyToMany', 
				'BelongsTo'
				),
			self::$path.'MVC/Relations/'
			);
		//
		self::call(
			array(
				'ManyRelationException', 
				'ModelNotFindedException'
				),
			self::$path.'MVC/Relations/Exceptions/'
			);
	}

	/**
	 * media calls
	 */
	public static function media()
	{
		self::need(self::$path.'Media/QR.php');
	}

	/**
	 * MVC view calls
	 */
	public static function view()
	{
		self::call(
			array(
				'View', 
				'Libs/Template', 
				'Libs/Views', 
				'Exceptions/ViewNotFoundException'
				),
			self::$path.'MVC/View/'
			);
	}

	/**
	 * controller calls
	 */
	public static function controller()
	{
		self::need(self::$path.'MVC/Controller.php');
	}

	/**
	 * dataCollection calls
	 */
	public static function dataCollection()
	{
		self::need(self::$path.'Objects/DataCollection.php');
	}

	/**
	 * fileSystem calls
	 */
	public static function fileSystem()
	{
		self::call(
			array(
				'Exceptions/FileNotFoundException', 
				'Exceptions/DirectoryNotFoundException', 
				'Filesystem',
				'File',
				),
			self::$path.'Filesystem/'
			);
	}

	/**
	 * intro call
	 */
	public static function intro()
	{
		self::need(self::$path.'Access/Intro.php');
	}

	/**
	 * Mocking call
	 */
	public static function mock()
	{
		self::call(
			array(
				'configMocking'
				),
			self::$path.'Mocking/'
			);
	}

	/**
	 * plugins call
	 */
	public static function plugins()
	{
		self::need(self::$path.'Plugins/Plugins.php');
		self::need(self::$path.'Plugins/Exceptions/AutoloadFileNotFound.php'
			);
		self::need(self::$path.'Plugins/Exceptions/InfoStructureException.php');
	}

	/**
	 * Require files of Lumos
	 */
	protected static function commands()
	{
		foreach (self::fetch(self::$path."Lumos/Commands") as $file) 
			Connector::need($file);
	}

	/**
	 * Setup call
	 */
	public static function setup()
	{
		self::call(
			array(
				'Routes', 
				'Setup', 
				'Response', 
				'Documentations/Database', 
				'Documentations/Panel', 
				'Documentations/Security', 
				'Documentations/Maintenance', 
				'Documentations/Loggin', 
				'Documentations/Translator', 
				'Documentations/App', 
				'Documentations/Robots', 
				),
			self::$path.'Setup/'
			);
	}

	/**
	 * lumos call
	 */
	public static function lumos()
	{
		self::call(
			array(
				'cmdOutput', 
				'bashOutput', 
				'Argument', 
				'Option', 
				'Command'
				),
			self::$path.'Lumos/'
			);
		//
		self::commands();
		// 
		self::need(self::$path.'Lumos/Console.php');
		self::need(self::$path.'Lumos/Response/ConfigSetting.php');
	}

	/**
	 * Bridge call
	 */
	public static function bridge()
	{
		self::call(
			array(
				'route',
				'Controllers/Response',
				),
			self::$path.'Bridge/'
			);
	}

	/**
	* call validation classes
	*
	* @return null
	*/
	public static function validation()
	{
		self::call(
			array(
				'Validator',
				'ValidationResult',
				),
			self::$path.'Validation/'
			);

		Validator::ini();
	}


	/**
	* call events calls
	*
	*/
	public static function event()
	{
		self::call(
			array(
				'Event',
				'EventListener',
				),
			self::$path.'Event/'
			);

		self::need(self::$path.'Event/Exceptions/ManyListenersArgumentsException.php');
	}
	
	

	/**
	 * atomium call
	 */
	public static function atomium()
	{
		self::call(
			array(
				'Atomium', 
				'Compiler',
				//
				'Compiler/AtomiumUserTags',
				//
				'Compiler/AtomiumCompileCSS',
				'Compiler/AtomiumCompileJS',
				'Compiler/AtomiumCompileAssign',
				'Compiler/AtomiumCompileRun',
				//
				'Compiler/AtomiumCompileComments',
				'Compiler/AtomiumCompileComment',
				//
				'Compiler/AtomiumCompileInstruction',
				'Compiler/AtomiumCompileInstructions',
				'Compiler/AtomiumCompileIf',
				'Compiler/AtomiumCompileFor',
				'Compiler/AtomiumCompileEndFor',
				'Compiler/AtomiumCompileBreak',
				'Compiler/AtomiumCompileOneLineComment',
				'Compiler/AtomiumCompileElse',
				'Compiler/AtomiumCompileEndIf',
				'Compiler/AtomiumCompileElseIf',
				'Compiler/AtomiumCompileForeach',
				'Compiler/AtomiumCompileEndForeach',
				'Compiler/AtomiumCompileWhile',
				'Compiler/AtomiumCompileEndWhile',
				'Compiler/AtomiumCompileUntil',
				'Compiler/AtomiumCompileEndUntil',
				'Compiler/AtomiumCompileSub',
				'Compiler/AtomiumCompileExec',
				//
				'Compiler/AtomiumCompileLang',
				//
				'Compiler/AtomiumCompileTake',
				'Compiler/AtomiumCompileCapture',
				//
				'Exception/AromiumCaptureNotFoundException',
				

				),
			self::$path.'Atomium/'
			);
		Compiler::setUserTags();
	}

	/**
	 * process call
	 */
	public static function process()
	{	
		self::call(
			array(
				'Command',
				'Process',
				'Translator',
				'Schema',
				'Links',
				'Tag',
				'Model',
				'View',
				'Controller',
				'Seeds',
				'Routes',
				'Exception',
				'Events',
				'Alias',
				'Middleware',
				'Helper',
				),
			self::$path.'Processes/'
			);
		//
		self::need(self::$path.'Processes/Exceptions/TranslatorFolderNeededException.php');
		self::need(self::$path.'Processes/Exceptions/TranslatorManyFolderException.php');
	}

	/**
	 * Run connector for test
	 */
	public static function runTest($kernelTest = false)
	{
		Connector::ini(true);
		Connector::loggin();
		Connector::input();
		Input::register();

		Connector::mock();
		// Config
		Connector::config();
		Config::load($kernelTest);
		//
		Connector::time();
		//
		Log::ini();
		$handler=new Error;
		$handler->register();
		//
		Connector::storage(false);
		Connector::maintenance();
		Connector::string();
		Connector::object();
		Connector::access();
		Connector::validation();
		if(Component::isOn("faker"))  Connector::faker();
		Connector::cookie();
		Connector::router();
		Connector::caches();
		Connector::security();
		Connector::table();
		if(Component::isOn("database")) Connector::database();
		Connector::object_scnd();
		Connector::http();
		Connector::assets();
		Connector::Html();
		Connector::hypertext();
		Connector::translator();
		Connector::model();
		Connector::relations();
		Connector::media();
		Connector::view();
		Connector::controller();
		Connector::mail();
		Connector::dataCollection();
		Connector::fileSystem();
		Connector::intro();
		Connector::plugins();
		Connector::events();
	}

	/**
	 * Fetch files of folder
	 */
	public static function fetch($pattern,$app = false)
	{
		if($app) return glob( Application::$root . "app/" . $pattern . '/*.php' );
		else return glob( Application::$root . $pattern . '/*.php' );
	}
}

