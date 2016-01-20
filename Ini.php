<?php

//----------------------------------------
// Fiesta (http://ipixa.net)
// Copyright 2014 - 2016 Youssef Had, Inc.
// Licensed under Open Source
//----------------------------------------

namespace Fiesta\Core\Glob;

use Fiesta\Core\Storage\Session;
use Fiesta\Core\Logging\Handler;
use Fiesta\Core\Config\Alias;
use Fiesta\Core\Objects\Sys;
use Fiesta\Core\Access\Url;
use Fiesta\Core\Access\Path;
use Fiesta\Core\MVC\View\Template;
use Fiesta\Core\Resources\Faker;
use Fiesta\Core\Http\Links;
use Fiesta\Core\Http\Errors;
use Fiesta\Core\Security\License;
use Fiesta\Core\Translator\Lang;
use Fiesta\Core\Database\Database;
use Fiesta\Core\Security\Auth;
use Fiesta\Core\Router\Routes;
use Fiesta\Core\Config\Config;
use Fiesta\Core\Logging\Log;
use Fiesta\Core\Objects\DateTime;
use Fiesta\Vendor\Panel\Panel;


class App
{
	static $page;
	public static $root;
	public static $Callbacks = array('before'=>null,'after'=>null);

	public static function version()
	{
		return "Fiesta v3 (3.0.0) PHP Framework";
	}

	public static function run($p=null,$root=null,$routes=true,$session=true)
	{
		ob_start();
		//
		self::$page=$p;
		self::$root=$root;
		
		self::vendor();
		//
		require self::$root.'../core/Logging/Handler.php';
		require self::$root.'../core/Logging/Log.php';

		// Config
		require self::$root.'../core/Config/Config.php';
		require self::$root.'../core/Config/Exceptions/ConfigException.php';
		Config::load();

		// Set Timezone
		self::timeCall();

		// Set the error log
		Log::ini();

		// Set Whoops error handler
		Handler::ini(self::$root);

		//session
		require self::$root.'../core/Storage/Session.php';
		if($session) Session::start(self::$root.'../app/storage/session');

		//Maintenance
		require self::$root.'../core/Maintenance/Maintenance.php';

		//Objects
		require self::$root.'../core/Objects/Vars.php';
		require self::$root.'../core/Objects/String/String.php';
		require self::$root.'../core/Objects/String/Exceptions/StringOutIndexException.php';

		// Access
		require self::$root.'../core/Access/Path.php';

		//Alias
		require self::$root.'../core/Config/Alias.php';

		//
		//require self::$root.'../core/MVC/Templete.php';
		require self::$root.'../core/Objects/Exception.php';
		require self::$root.'../core/Resources/Faker.php';

		require self::$root.'../core/Storage/Cookie.php';

		// Routes
		require self::$root.'../core/Router/Routes.php';
		require self::$root.'../core/Router/Route.php';
		require self::$root.'../core/Router/Exceptions/NotFoundHttpException.php';

		// Caches
		require self::$root.'../core/Caches/Caches.php';
		require self::$root.'../core/Caches/Cache.php';
		require self::$root.'../core/Caches/FileCache.php';
		require self::$root.'../core/Caches/DatabaseCache.php';
		require self::$root.'../core/Caches/Exceptions/DriverNotFoundException.php';


		require self::$root.'../core/Storage/Storage.php';
		require self::$root.'../core/Security/Auth.php';
		require self::$root.'../core/Objects/Table.php';

		// Database
		require self::$root.'../core/Database/Schema.php';
		require self::$root.'../core/Database/Migration.php';
		require self::$root.'../core/Database/Seeder.php';
		require self::$root.'../core/Database/Database.php';
		require self::$root.'../core/Database/Drivers/MySql.php';
		require self::$root.'../core/Database/Exceptions/DatabaseArgumentsException.php';
		require self::$root.'../core/Database/Exceptions/DatabaseConnectionException.php';


		require self::$root.'../core/Access/Url.php';
		
		require self::$root.'../core/Objects/Sys.php';
		require self::$root.'../core/Http/Links.php';
		require self::$root.'../core/Http/Http.php';
		require self::$root.'../core/Objects/Base.php';
		require self::$root.'../core/Resources/Libs.php';
		require self::$root.'../core/Hypertext/Res.php';
		require self::$root.'../core/Hypertext/Input.php';
		require self::$root.'../core/Security/License.php';

		
		self::translatorCalls();
		self::modelsCalls();
		self::relationsCalls();
		self::mediaCalls();

		// MVC - View

		require self::$root.'../core/MVC/View/View.php';
		require self::$root.'../core/MVC/View/Libs/Template.php';
		require self::$root.'../core/MVC/View/Libs/Views.php';
		require self::$root.'../core/MVC/View/Exceptions/ViewNotFoundException.php';

		require self::$root.'../core/Hypertext/HTML.php';
		require self::$root.'../core/Security/Encrypt.php';
		require self::$root.'../core/Security/Security.php';
		require self::$root.'../core/MVC/Controller.php';
		require self::$root.'../core/Http/Error.php';
		require self::$root.'../core/Http/Root.php';
		require self::$root.'../core/Mailing/Mail.php';
		require self::$root.'../core/Objects/DataCollection.php';
		require self::$root.'../core/Maintenance/Debug.php';

		// Filesystem
		require self::$root.'../core/Filesystem/Exceptions/FileNotFoundException.php';
		require self::$root.'../core/Filesystem/Exceptions/DirectoryNotFoundException.php';
		require self::$root.'../core/Filesystem/Filesystem.php';

		// Database files
		require self::$root.'../core/Database/DBTable.php';

		//


		Alias::ini(self::$root);
		Sys::ini();
		Url::ini();
		Path::ini();
		Template::ini(self::$root);
		Faker::ini();
		Links::ini($root);
		Errors::ini($root);
		License::ini(self::$page);
		Lang::ini();
		Database::ini();
		Auth::ini();
		Panel::run();
		self::scoopCall();

		//

		if($root!=null)
		{
			// include models
			foreach (glob($root."../app/models/*.php") as $file) { include_once $file; }

			//include the controllers files
			foreach (glob($root."../app/controllers/*.php") as $file) { include_once $file; }

			//include the link files
			foreach (glob($root."../app/paths/*.php") as $file) { include_once $file; }

			//include the seeders files
			foreach (glob($root."../app/seeds/*.php") as $file) { include_once $file; }
			//
			//include filters
			include_once $root."../app/http/Filters.php";

			//include for routes
			if($routes)
			{
				include_once $root."../app/http/Routes.php";
				Routes::run();
			}
		}
		else
		{
			// include models
			foreach (glob("../app/models/*.php") as $file) { include_once $file; }

			//include the controllers files
			foreach (glob("../app/controllers/*.php") as $file) { include_once $file; }

			//include the seeders files
			foreach (glob("../app/seeds/*.php") as $file) { include_once $file; }


			//include filters
			include_once "../app/http/Filters.php";

			//include for routes
			if($routes)
			{
				include_once "../app/http/Routes.php";
				Routes::run();
			}
		}

		return true;
	}

	/**
	 * call vendor
	 */
	public static function vendor()
	{
		self::checkVendor();
		$path = is_null(App::$root) ? '../vendor/autoload.php' : App::$root.'../vendor/autoload.php';
		include_once $path;
	}

	/**
	 * check if vendor existe
	 */
	public static function checkVendor()
	{
		if( ! file_exists('../vendor/autoload.php')) die("You should install fiesta dependencies by composer commande 'composer install' :)");
	}

	public static function before($fun)
	{
		self::$Callbacks['before']=$fun;
	}

	public static function after($fun)
	{
		self::$Callbacks['after']=$fun;
	}

	public static function root()
	{
		$sub=$_SERVER["PHP_SELF"];
		$r=explode("App.php", $sub);
		//
		return "http://".$_SERVER["HTTP_HOST"].$r[0];
	}

	/**
	 * Call files
	 * @param $files array
	 * @param $path string
	 */
	public static function call($files,$path)
	{
		foreach ($files as $file)
			require $path.$file.".php";
	}

	/**
	 * MVC Model relationships calls
	 */
	public static function relationsCalls()
	{
		// Files of relation
		$files = array('OneToOne', 'OneToMany', 'ManyToMany', 'BelongsTo');
		$filesPath = self::$root.'../core/MVC/Relations/';
		self::call($files,$filesPath);

		// Exeptions of relation
		$exceptions = array('ManyRelationException', 'ModelNotFindedException');
		$exceptionsPath = self::$root.'../core/MVC/Relations/Exceptions/';
		self::call($exceptions,$exceptionsPath);
	}

	/**
	 * MVC Model calls
	 */
	public static function modelsCalls()
	{
		// Files of models
		$files = array('Model', 'ModelArray');
		$filesPath = self::$root.'../core/MVC/Model/';
		self::call($files,$filesPath);

		// Exeptions of models
		$exceptions = array('ForeingKeyMethodException', 'ColumnNotEmptyException', 'ManyPrimaryKeysException', 'PrimaryKeyNotFoundException');
		$exceptionsPath = self::$root.'../core/MVC/Model/Exceptions/';
		self::call($exceptions,$exceptionsPath);
	}

	/**
	 * Translator calls
	 */
	public static function translatorCalls()
	{
		// Files of models
		$files = array('Lang', 'Smiley');
		$filesPath = self::$root.'../core/Translator/';
		self::call($files,$filesPath);

		// Exeptions of models
		$exceptions = array('LanguageKeyNotFoundException');
		$exceptionsPath = self::$root.'../core/Translator/Exceptions/';
		self::call($exceptions,$exceptionsPath);
	}

	/**
	 * Media calls
	 */
	public static function mediaCalls()
	{
		// Files of models
		$files = array('QR');
		$filesPath = self::$root.'../core/Media/';
		self::call($files,$filesPath);
	}

	/**
	 * scoop call
	 */
	public static function scoopCall()
	{
		$files = array('Scope');
		$filesPath = self::$root.'../core/Access/';
		self::call($files,$filesPath);
	}

	/**
	 * time call
	 */
	public static function timeCall()
	{
		require self::$root.'../core/Objects/DateTime.php';
		DateTime::setTimezone();
	}
}
