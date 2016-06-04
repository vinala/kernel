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
	public static function setGlob_step()
	{
		$name=$_POST['dev_name'];
		$langue=$_POST['langue'];
		//
		if(isset($_POST['ckeck_loggin'])) $loggin="true";
		else $loggin="false";
		//
		if(isset($_POST['ckeck_maintenance'])) $maintenance="true";
		else $maintenance="false";
		//
		if( ! Application::$isTest)
		{
			$appCont = App::set($name);
			$translatorCont = Translator::set($langue);
			$logginCont = Loggin::set($loggin);
			$maintenanceCont = Maintenance::set($maintenance);
			//
			file_put_contents(Application::$root."config/app.php", $appCont , 0);
			file_put_contents(Application::$root."config/lang.php", $translatorCont, 0);
			file_put_contents(Application::$root."config/loggin.php", $logginCont, 0);
			file_put_contents(Application::$root."config/maintenance.php", $maintenanceCont, 0);
			//
			echo "true";
		}
	}

	/**
	 * set security setup
	 */
	public static function setSecur_step()
	{
		$sec_1=$_POST['sec_1'];
		$sec_2=$_POST['sec_2'];
		//
		if( ! Application::$isTest) 
		{
			$content = Security::set($sec_1,$sec_2);
			//
			file_put_contents(Application::$root."config/security.php", $content , 0);
			//
			echo "true";
		}
	}

	/**
	 * set panel setup
	 */
	public static function setPanel_step()
	{
		if(isset($_POST['stat'])) $state="true";
		else $state="false";
		//
		$route=empty($_POST['route']) ? "lighty" : $_POST['route'];
		$pass_1=empty($_POST['pass_1']) ? "1234" : $_POST['pass_1'];
		$pass_2=empty($_POST['pass_2']) ? "5678" : $_POST['pass_2'];
		//
		if( ! Application::$isTest) 
		{
			$content = Panel::set($state,$route,$pass_1,$pass_2);
			//
			file_put_contents(Application::$root."config/panel.php", $content, 0);
			//
			echo "true";
		}
	}
}