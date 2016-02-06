<?php

//----------------------------------------
// Fiesta (http://ipixa.net)
// Copyright 2014 - 2016 Youssef Had, Inc.
// Licensed under Open Source
//----------------------------------------

namespace Fiesta\Kernel\Foundation;

use Fiesta\Kernel\Storage\Session;
use Fiesta\Kernel\Logging\Handler;
use Fiesta\Kernel\Config\Alias;
use Fiesta\Kernel\Objects\Sys;
use Fiesta\Core\Access\Url;
use Fiesta\Core\Access\Path;
use Fiesta\Core\MVC\View\Template;
use Fiesta\Core\Resources\Faker;
use Fiesta\Core\Http\Links;
use Fiesta\Core\Http\Errors;
use Fiesta\Kernel\Security\License;
use Fiesta\Core\Translator\Lang;
use Fiesta\Kernel\Database\Database;
use Fiesta\Kernel\Security\Auth;
use Fiesta\Kernel\Router\Routes;
use Fiesta\Kernel\Config\Config;
use Fiesta\Kernel\Logging\Log;
use Fiesta\Kernel\Objects\DateTime;
use Fiesta\Vendor\Panel\Panel;


class Application
{
	static $page;
	public static $root;
	public static $Callbacks = array('before'=>null,'after'=>null);

	public static function version()
	{
		return "Fiesta v3 (3.0.0) PHP Framework";
	}

	public static function run($root=null,$routes=true,$session=true)
	{
		ob_start();
		//
		self::$root=$root."../";
		//
		require self::$root.'vendor/fiesta/kernel/Logging/Handler.php';
		require self::$root.'vendor/fiesta/kernel/Logging/Log.php';

		// Config
		require self::$root.'vendor/fiesta/kernel/Config/Config.php';
		require self::$root.'vendor/fiesta/kernel/Config/Exceptions/ConfigException.php';
		Config::load();

		// Set Timezone
		self::timeCall();

		// Set the error log
		Log::ini();

		// Set Whoops error handler
		Handler::run();

		//session
		require self::$root.'vendor/fiesta/kernel/Storage/Session.php';
		if($session) Session::start(self::$root.'app/storage/session');

		//Maintenance
		require self::$root.'vendor/fiesta/kernel/Maintenance/Maintenance.php';

		//Objects
		require self::$root.'vendor/fiesta/kernel/Objects/Vars.php';
		require self::$root.'vendor/fiesta/kernel/Objects/String/String.php';
		require self::$root.'vendor/fiesta/kernel/Objects/String/Exceptions/StringOutIndexException.php';

		// Access
		require self::$root.'vendor/fiesta/kernel/Access/Path.php';

		//Alias
		require self::$root.'vendor/fiesta/kernel/Config/Alias.php';

		//
		//require self::$root.'vendor/fiesta/kernel/MVC/Templete.php';
		require self::$root.'vendor/fiesta/kernel/Objects/Exception.php';
		require self::$root.'vendor/fiesta/kernel/Resources/Faker.php';

		require self::$root.'vendor/fiesta/kernel/Storage/Cookie.php';

		// Routes
		require self::$root.'vendor/fiesta/kernel/Router/Routes.php';
		require self::$root.'vendor/fiesta/kernel/Router/Route.php';
		require self::$root.'vendor/fiesta/kernel/Router/Exceptions/NotFoundHttpException.php';

		// Caches
		require self::$root.'vendor/fiesta/kernel/Caches/Caches.php';
		require self::$root.'vendor/fiesta/kernel/Caches/Cache.php';
		require self::$root.'vendor/fiesta/kernel/Caches/FileCache.php';
		require self::$root.'vendor/fiesta/kernel/Caches/DatabaseCache.php';
		require self::$root.'vendor/fiesta/kernel/Caches/Exceptions/DriverNotFoundException.php';


		require self::$root.'vendor/fiesta/kernel/Storage/Storage.php';
		require self::$root.'vendor/fiesta/kernel/Security/Auth.php';
		require self::$root.'vendor/fiesta/kernel/Objects/Table.php';

		// Database
		require self::$root.'vendor/fiesta/kernel/Database/Schema.php';
		require self::$root.'vendor/fiesta/kernel/Database/Migration.php';
		require self::$root.'vendor/fiesta/kernel/Database/Seeder.php';
		require self::$root.'vendor/fiesta/kernel/Database/Database.php';
		require self::$root.'vendor/fiesta/kernel/Database/Drivers/MySql.php';
		require self::$root.'vendor/fiesta/kernel/Database/Exceptions/DatabaseArgumentsException.php';
		require self::$root.'vendor/fiesta/kernel/Database/Exceptions/DatabaseConnectionException.php';


		require self::$root.'vendor/fiesta/kernel/Access/Url.php';
		
		require self::$root.'vendor/fiesta/kernel/Objects/Sys.php';
		require self::$root.'vendor/fiesta/kernel/Http/Links.php';
		require self::$root.'vendor/fiesta/kernel/Http/Http.php';
		require self::$root.'vendor/fiesta/kernel/Objects/Base.php';
		require self::$root.'vendor/fiesta/kernel/Resources/Libs.php';
		require self::$root.'vendor/fiesta/kernel/Hypertext/Res.php';
		require self::$root.'vendor/fiesta/kernel/Hypertext/Input.php';
		require self::$root.'vendor/fiesta/kernel/Security/License.php';

		
		self::translatorCalls();
		self::modelsCalls();
		self::relationsCalls();
		self::mediaCalls();

		// MVC - View

		require self::$root.'vendor/fiesta/kernel/MVC/View/View.php';
		require self::$root.'vendor/fiesta/kernel/MVC/View/Libs/Template.php';
		require self::$root.'vendor/fiesta/kernel/MVC/View/Libs/Views.php';
		require self::$root.'vendor/fiesta/kernel/MVC/View/Exceptions/ViewNotFoundException.php';

		require self::$root.'vendor/fiesta/kernel/Hypertext/HTML.php';
		require self::$root.'vendor/fiesta/kernel/Security/Encrypt.php';
		require self::$root.'vendor/fiesta/kernel/Security/Security.php';
		require self::$root.'vendor/fiesta/kernel/MVC/Controller.php';
		require self::$root.'vendor/fiesta/kernel/Http/Error.php';
		require self::$root.'vendor/fiesta/kernel/Http/Root.php';
		require self::$root.'vendor/fiesta/kernel/Mailing/Mail.php';
		require self::$root.'vendor/fiesta/kernel/Objects/DataCollection.php';
		require self::$root.'vendor/fiesta/kernel/Maintenance/Debug.php';

		// Filesystem
		require self::$root.'vendor/fiesta/kernel/Filesystem/Exceptions/FileNotFoundException.php';
		require self::$root.'vendor/fiesta/kernel/Filesystem/Exceptions/DirectoryNotFoundException.php';
		require self::$root.'vendor/fiesta/kernel/Filesystem/Filesystem.php';

		// Database files
		require self::$root.'vendor/fiesta/kernel/Database/DBTable.php';

		//


		Alias::ini(self::$root);
		Sys::ini();
		Url::ini();
		Path::ini();
		Template::run();
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
		$path = is_null(self::$root) ? 'vendor/autoload.php' : self::$root.'vendor/autoload.php';
		include_once $path;
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
		$filesPath = self::$root.'vendor/fiesta/kernel/MVC/Relations/';
		self::call($files,$filesPath);

		// Exeptions of relation
		$exceptions = array('ManyRelationException', 'ModelNotFindedException');
		$exceptionsPath = self::$root.'vendor/fiesta/kernel/MVC/Relations/Exceptions/';
		self::call($exceptions,$exceptionsPath);
	}

	/**
	 * MVC Model calls
	 */
	public static function modelsCalls()
	{
		// Files of models
		$files = array('Model', 'ModelArray');
		$filesPath = self::$root.'vendor/fiesta/kernel/MVC/Model/';
		self::call($files,$filesPath);

		// Exeptions of models
		$exceptions = array('ForeingKeyMethodException', 'ColumnNotEmptyException', 'ManyPrimaryKeysException', 'PrimaryKeyNotFoundException');
		$exceptionsPath = self::$root.'vendor/fiesta/kernel/MVC/Model/Exceptions/';
		self::call($exceptions,$exceptionsPath);
	}

	/**
	 * Translator calls
	 */
	public static function translatorCalls()
	{
		// Files of models
		$files = array('Lang', 'Smiley');
		$filesPath = self::$root.'vendor/fiesta/kernel/Translator/';
		self::call($files,$filesPath);

		// Exeptions of models
		$exceptions = array('LanguageKeyNotFoundException');
		$exceptionsPath = self::$root.'vendor/fiesta/kernel/Translator/Exceptions/';
		self::call($exceptions,$exceptionsPath);
	}

	/**
	 * Media calls
	 */
	public static function mediaCalls()
	{
		// Files of models
		$files = array('QR');
		$filesPath = self::$root.'vendor/fiesta/kernel/Media/';
		self::call($files,$filesPath);
	}

	/**
	 * scoop call
	 */
	public static function scoopCall()
	{
		$files = array('Scope');
		$filesPath = self::$root.'vendor/fiesta/kernel/Access/';
		self::call($files,$filesPath);
	}

	/**
	 * time call
	 */
	public static function timeCall()
	{
		require self::$root.'vendor/fiesta/kernel/Objects/DateTime.php';
		DateTime::setTimezone();
	}
}
