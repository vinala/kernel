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
		//
		Route::get(Config::get('dashboard.token')."_/{op}",function($op){
			switch ($op) {
				case 'new_model': Response::createModel();  break;
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


}