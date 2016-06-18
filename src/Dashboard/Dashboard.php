<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Config\Alias;
use Lighty\Kernel\Config\Config;

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
		self::$assets = "vendor/lighty/kernel/src/Dashboard/";
		//
		Alias::set(\Lighty\Kernel\Dashboard\Dashboard::class, 'Dashboard');
	}

	public static function getOwner()
	{
		return Config::get("app.owner");
	}


}