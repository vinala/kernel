<?php 

namespace Vinala\Kernel\Maintenance ;

use Vinala\Kernel\Router\Route;

/**
* Maintenance class
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Maintenance
* @since v2.5.0.236 / v3.3.0
*/
class Maintenance
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------
	
	/**
	* Is the maintenance up or down
	*
	* @var bool 
	*/
	public static $enabled ;
	

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Check if the app is under maintenance
	*
	* @return bool
	*/
	public static function check()
	{
		$route = $_GET['_framework_url_'];
		
		if (config('panel.setup' , true)) 
		{
			if(config('maintenance.enabled' , false ) && ! in_array($route, config('maintenance.out' , [])))
			{
				return static::$enabled = true;
			}
		}
		return static::$enabled = false;
	}

	/**
	* Launch maintenance view
	*
	* @return null
	*/
	public static function Launch()
	{
		if(static::check())
		{
			clean();
			include '../app/views/errors/maintenance.php';
			out('');
		}
	}
	
	

}
