<?php 

namespace Pikia\Kernel\Foundation;

use Pikia\Kernel\Config\Config;
use Pikia\Kernel\Logging\Log;
use Pikia\Kernel\Logging\Handler;
use Pikia\Kernel\Foundation\Exception\ConnectorFileNotFoundException as CFNFE;
use Pikia\Kernel\Foundation\Application;

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
	public static function run($console = false)
	{
		if( ! $console) Connector::ini();
		else Connector::iniConsole();
		//**/
		Connector::loggin();

		// Config
		Connector::config();
		Config::load();
		//
		Connector::time();
		//
		Log::ini();
		Handler::run();
		//
		Connector::storage();
		Connector::maintenance();
		Connector::string();
		Connector::object();
		Connector::access();
		Connector::faker();
		Connector::cookie();
		Connector::router();
		Connector::caches();
		Connector::security();
		Connector::table();
		Connector::database();
		Connector::object_scnd();
		Connector::http();
		Connector::libs();
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
		Connector::scoop();
		Connector::intro();
		Connector::plugins();
		Connector::console();
		Connector::process();
	}

	/**
	 * Init Connector class
	 */
	public static function ini($test = false)
	{
		self::$path = $test ? "src/" : Application::$root."vendor/fiesta/kernel/src/";
		return self::$path;
	}

	/**
	 * Init Connector class
	 */
	public static function iniConsole()
	{
		// self::$path = $test ? "src/" : Application::$root."vendor/Pikia/kernel/src/";
		self::$path = "vendor/fiesta/kernel/src/";
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
	 * Logging
	 **/
	public static function logging()
	{
		$files = array('Handler', 'Log');
		$filesPath = self::$path.'Logging/';
		self::call($files,$filesPath);
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
		self::need(self::$path.'Config/Exceptions/ConfigException.php');
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
	// if( ! file_exists('../vendor/autoload.php')) die("You should install Pikia dependencies by composer commande 'composer install' :)");
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
		// if($session) Session::start(self::$root.'app/storage/session');
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
	public static function maintenance()
	{
		self::need(self::$path.'Maintenance/Maintenance.php');
		self::need(self::$path.'Maintenance/Debug.php');
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
				'Log'
				),
			self::$path.'Logging/'
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
		self::call(
			array(
				'Schema', 
				'Migration', 
				'Seeder', 
				'DBTable', 
				'Database'
				),
			self::$path.'Database/'
			);
		//
		self::need(self::$path.'Database/Drivers/MySql.php');
		//
		self::call(
			array(
				'DatabaseArgumentsException', 
				'DatabaseConnectionException'
				),
			self::$path.'Database/Exceptions/'
			);
	}

	/**
	 * http calls
	 */
	public static function http()
	{
		self::call(
			array(
				'Links',
				'Http',
				'Error',
				'Root'
				),
			self::$path.'Http/'
			);
	}

	/**
	 * libs calls
	 */
	public static function libs()
	{
		self::need(self::$path.'Resources/Libs.php');
	}

	/**
	 * hypertext calls
	 */
	public static function hypertext()
	{
		self::call(
			array(
				'Res',
				'HTML',
				'Input'
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
	}

	/**
	 * model calls
	 */
	public static function model()
	{
		self::call(
			array(
				'Model',
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
				'Filesystem'
				),
			self::$path.'Filesystem/'
			);
	}

	/**
	 * scoop call
	 */
	public static function scoop()
	{
		self::need(self::$path.'Access/Scope.php');
	}

	/**
	 * intro call
	 */
	public static function intro()
	{
		self::need(self::$path.'Access/Intro.php');
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
	 * Require files of Console
	 */
	protected static function commands()
	{
		foreach (self::fetch(self::$path."Console/Commands") as $file) 
			Connector::need($file);
	}

	/**
	 * console call
	 */
	public static function console()
	{
		
		//
		// self::need(self::$path.'Console/Commands/Command/NewCommand.php');

		//
		self::need(self::$path.'Console/cmdOutput.php');
		self::need(self::$path.'Console/bashOutput.php');
		//
		self::need(self::$path.'Console/Command.php');
		//
		
		//
		self::commands();
		// self::need(self::$path.'Console/Commands/testCommand.php');
		//
		self::need(self::$path.'Console/Console.php');
		
		
		

		//
		//

		// self::need(self::$path.'Console/Commands/Translator/NewDir.php');
		// self::need(self::$path.'Console/Commands/Translator/NewFile.php');
		//
	
		//
		
		//
		
		//
		// self::need(self::$path.'Console/Commands/Views/NewViewCommand.php');
		//
		// self::need(self::$path.'Console/Commands/Controller/NewControllerCommand.php');
		//
		// self::need(self::$path.'Console/Commands/Seeds/NewSeedCommand.php');
		// self::need(self::$path.'Console/Commands/Seeds/ExecSeedCommand.php');
		//
		// self::need(self::$path.'Console/Commands/Various/AllCommand.php');
		//
		
		//
		// self::need(self::$path.'Console/Commands/Info.php');
		
	}

	/**
	 * process call
	 */
	public static function process()
	{
		self::need(self::$path.'Processes/Command.php');
		self::need(self::$path.'Processes/Process.php');
		self::need(self::$path.'Processes/Translator.php');
		self::need(self::$path.'Processes/Schema.php');
		self::need(self::$path.'Processes/Links.php');
		self::need(self::$path.'Processes/Model.php');
		self::need(self::$path.'Processes/View.php');
		self::need(self::$path.'Processes/Controller.php');
		self::need(self::$path.'Processes/Seeds.php');
		self::need(self::$path.'Processes/Routes.php');
	}

	/**
	 * Run connector for test
	 */
	public static function runTest()
	{
		Connector::ini(true);
		Connector::loggin();

		// Config
		Connector::config();
		Config::load();
		//
		Connector::time();
		//
		Log::ini();
		Handler::run();
		//
		Connector::storage();
		Connector::maintenance();
		Connector::string();
		Connector::object();
		Connector::access();
		Connector::faker();
		Connector::cookie();
		Connector::router();
		Connector::caches();
		Connector::security();
		Connector::table();
		Connector::database();
		Connector::object_scnd();
		Connector::http();
		Connector::libs();
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
		Connector::scoop();
		Connector::intro();
		Connector::plugins();
	}

	/**
	 * Fetch files of folder
	 */
	protected static function fetch($pattern)
	{
		// die($pattern);
		return glob($pattern.'/*.php');
	}
}

