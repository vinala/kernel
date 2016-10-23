<?php

namespace Lighty\Kernel\Setup;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\MVC\View\View;
use Lighty\Kernel\Setup\Documentations\Database;
use Lighty\Kernel\Setup\Documentations\Panel;
use Lighty\Kernel\Setup\Documentations\Security;
use Lighty\Kernel\Setup\Documentations\Maintenance;
use Lighty\Kernel\Setup\Documentations\Loggin;
use Lighty\Kernel\Setup\Documentations\Translator;
use Lighty\Kernel\Setup\Documentations\App;
use Lighty\Kernel\Setup\Documentations\Robots;

/**
* class de controller helloController
*/

class Response
{
	/**
	 * get Database post data
	 */
	public static function setDb_step()
	{
		$host = $_POST['db_host'] ;
		$name = $_POST['db_name'];
		$usr = $_POST['db_usr'];
		$pass = $_POST['db_pass'];
		$prefix = $_POST['db_prefix'];
		//
		if( ! self::checkDb_step($host,$name,$usr,$pass,$prefix)) 
		{
			echo "false";
			die();
		}
		else
		{
			self::makeDb_step($host,$name,$usr,$pass,$prefix);
		}
	}

	/**
	 * Check if database existe
	 */
	protected static function checkDb_step($host,$name,$usr,$pass,$prefix)
	{
		if(@mysqli_connect($host,$usr,$pass,$name)) return true;
		else return false;
	}

	/**
	 * set data in database file
	 */
	protected static function makeDb_step($host,$name,$usr,$pass,$prefix)
	{
		if(empty($prefix)) { $prefixing="false"; $prefix="ysf"; }
		else  { $prefixing="true";  }
		//
		if( ! Application::$isTest) 
		{
			$content = Database::set($host,$name,$usr,$pass,$prefixing,$prefix);
			//
			file_put_contents(Application::$root."config/database.php", $content , 0);
			//
			echo "true";
		}
	}

	/**
	 * set global setup
	 */
	public static function setGlob_step($project , $name , $langue , $loggin , $robot)
	{
		if( ! Application::$isTest)
		{
			$appCont = App::set($name, $project);
			$translatorCont = Translator::set($langue);
			$logginCont = Loggin::set($loggin);
			Robots::set($robot);
			//
			file_put_contents(Application::$root."config/app.php", $appCont , 0);
			file_put_contents(Application::$root."config/lang.php", $translatorCont, 0);
			file_put_contents(Application::$root."config/loggin.php", $logginCont, 0);
			//
			return true;
		}
	}

	/**
	 * set security setup
	 */
	public static function setSecur_step($sec_1 , $sec_2)
	{
		if( ! Application::$isTest) 
		{
			$content = Security::set($sec_1,$sec_2);
			//
			file_put_contents(Application::$root."config/security.php", $content , 0);
			//
			return true;
		}
	}

	/**
	 * set panel setup
	 */
	public static function setPanel_step($state = false , $route , $pass_1 , $pass_2)
	{
		if( ! Application::$isTest) 
		{
			$state = $state ? "true" : "false" ;
			$content = Panel::set($state,$route,$pass_1,$pass_2);
			//
			file_put_contents(Application::$root."config/panel.php", $content, 0);
			//
			return true;
		}
	}
}