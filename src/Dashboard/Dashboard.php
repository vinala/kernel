<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Config\Alias;
use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Router\Route;
use Lighty\Kernel\Dashboard\Response;
use Lighty\Kernel\Objects\Strings;

/**
* Controller class
*/
class Dashboard
{
	public static $root;
	public static $assets;

	public static function ini()
	{
		self::$root = Application::$root."vendor/lighty/kernel/src/Dashboard/";
		self::$assets = Application::$root."vendor/lighty/kernel/src/Dashboard/";
		//
		Alias::set(\Lighty\Kernel\Dashboard\Dashboard::class, 'Dashboard');
		//
		self::route();
	}

	public static function getOwner()
	{
		return Config::get("app.owner");
	}

	protected static function callHome($page)
	{
		include_once '../vendor/lighty/kernel/src/Dashboard/views/home.php';  
	}

	/**
	* get the path of project home
	* @return string
	*/
	public static function home()
	{
		$url = Config::get('app.url');
		//
		$main = Strings::split($url , "/public/index.php");
		return $main[0];
	}
	

	public static function route()
	{
		Route::get(Config::get('dashboard.route')."/model",function(){ self::callHome("model"); });
		Route::get(Config::get('dashboard.route')."/view",function(){ self::callHome("view"); });
		Route::get(Config::get('dashboard.route')."/controller",function(){ self::callHome("controller"); });
		Route::get(Config::get('dashboard.route')."/schema",function(){ self::callHome("schema"); });
		Route::get(Config::get('dashboard.route')."/backup",function(){ self::callHome("backup"); });
		Route::get(Config::get('dashboard.route')."/seeders",function(){ self::callHome("seeder"); });
		Route::get(Config::get('dashboard.route')."/links",function(){ self::callHome("link"); });
		Route::get(Config::get('dashboard.route')."/translator",function(){ self::callHome("translate"); });
		//
		self::ajaxRoute();
	}

	public static function ajaxRoute()
	{
		Route::get(Config::get('dashboard.token')."_/{op}",function($op){
			switch ($op) {
				case 'new_model': Response::createModel();  break;
				case 'new_view': Response::createView();  break;
				case 'new_controller': Response::createController();  break;
				case 'new_schema': Response::createSchema();  break;
				case 'exec_schema': Response::execSchema();  break;
				case 'rollback_schema': Response::rollbackSchema();  break;
				case 'make_backup': Response::exportDatabase();  break;
				case 'make_seeder': Response::createSeeder();  break;
				case 'make_link': Response::createLink();  break;
				case 'make_translator': Response::createTranslator();  break;
			}
		});
	}

	public static function view($path, $data = null)
	{
		if($data)
			foreach ($data as $key => $value)
				$$key = $value;
		//
		include(Dashboard::$root.'views/'.$path.'.php');
	}

	public static function switcher($page)
	{
		switch ($page) {
			case 'model': include_once Dashboard::$root.'views/contents/model.php'; break;
			case 'view': include_once Dashboard::$root.'views/contents/view.php'; break;
			case 'controller': include_once Dashboard::$root.'views/contents/controller.php'; break;
			case 'schema': include_once Dashboard::$root.'views/contents/schema.php'; break;
			case 'backup': include_once Dashboard::$root.'views/contents/backup.php'; break;
			case 'seeder': include_once Dashboard::$root.'views/contents/Seeder.php'; break;
			case 'link': include_once Dashboard::$root.'views/contents/link.php'; break;
			case 'translate': include_once Dashboard::$root.'views/contents/translate.php'; break;
		}
	}
}