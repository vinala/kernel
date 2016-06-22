<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Config\Alias;
use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Router\Route;
use Lighty\Kernel\Dashboard\Response;

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

	public static function route()
	{
		Route::get(Config::get('dashboard.route')."/model",function(){ self::callHome("model"); });
		Route::get(Config::get('dashboard.route')."/view",function(){ self::callHome("view"); });
		Route::get(Config::get('dashboard.route')."/controller",function(){ self::callHome("controller"); });
		Route::get(Config::get('dashboard.route')."/schema",function(){ self::callHome("schema"); });
		Route::get(Config::get('dashboard.route')."/backup",function(){ self::callHome("backup"); });
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
		}
	}
}