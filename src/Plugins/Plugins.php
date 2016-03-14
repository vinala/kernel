<?php 

namespace Fiesta\Kernel\Plugins;

use Fiesta\Kernel\Foundation\Application;
use Fiesta\Kernel\Filesystem\Filesystem;
use Fiesta\Kernel\Plugins\Exception\AutoloadFileNotFound;
use Fiesta\Kernel\Objects\Strings;
use Fiesta\Kernel\Config\Alias;

/**
* 
*/
class Plugins
{
	/**
	 * All info about plugins
	 */
	protected static $infos = array();

	/**
	 * All info about plugins
	 */
	protected static $config = array();

	/**
	 * Init Plug-in class
	 */
	public static function ini()
	{
		
		// \Http::clear();
		self::getInfo();
		self::getConfig();
		//
		self::req();
	}

	/**
	 * Check if the plugin is enbled by user
	 */
	protected static function isEnabled($alias)
	{
		if(self::$config[$alias]["enable"]) return true;
	}

	protected static function req()
	{
		foreach (self::$infos as $key => $value) {
			if(self::isEnabled($key))
			{
				self::call($value);
				self::setAlias($key);
				self::exec($value);
			}
			
		}
	}

	/**
	 * Get infos about plug-ins
	 */
	protected static function getInfo()
	{
		$files = self::getFiles();
		//
		foreach ($files as $path) {
			$data = self::convert(self::readFile($path."/.info"));
			$data = $data['system'];
			$data['path']=$path;
			self::$infos[$data["alias"]]=$data;
		}
		//
		return self::$infos;
	}

	protected static function getConfig()
	{
		$files = self::getFiles();
		//
		foreach ($files as $path) {
			$data = self::convert(self::readFile($path."/.info"));
			$setting = $data['configuration'];
			$system = $data['system'];
			$setting['path']=$path;
			self::$config[$system["alias"]]=$setting;
		}
		//
		return self::$infos;
	}

	/**
	 * Convert JSON to PHP array
	 */
	protected static function convert($string)
	{
		return json_decode($string,true);
	}

	/**
	 * Get content of file
	 */
	protected static function readFile($path)
	{
		return (new Filesystem())->get($path);
	}

	/**
	 * Get all info files path
	 */
	protected static function getFiles()
	{
		$files = array();
		//
		foreach (glob(Application::$root."plugins/*") as  $value) {
			$files[] = $value;
		}
		//
		return $files;
	}

	protected static function call($info)
	{
		$file = $info["path"]."/".$info["autoload"]["file"];
		//
		if((new Filesystem())->exists($file)) include $file;
		else throw new AutoloadFileNotFound($file);
		

	}

	protected static function exec($info)
	{
		$use = isset($info["autoload"]["script"]);
		if($use)
		{
			$callback = Strings::replace($info["autoload"]["script"],"/","\\");
			//
			call_user_func($callback);
		}
	}

	protected static function isConfigKeyExist()
	{
		$args = func_get_args();
		//
		$data = self::$config;
		foreach ($args as $value) {
			if(isset($data[$value])) { $data = $data[$value]; break;  }
			else return false;
		}
		return true;
	}

	protected static function isInfoKeyExist()
	{
		$args = func_get_args();
		//
		$data = self::$infos;
		foreach ($args as $value) {
			if(isset($data[$value])) { $data = $data[$value];  }
			else return false;
		}
		return true;
	}

	/**
	 * Set classes aliases
	 */
	protected static function setAlias($alias)
	{
		if(self::isConfigKeyExist($alias,"shortcuts"))
		{
			$shortcuts = self::$config[$alias]["shortcuts"];
			//
			foreach ($shortcuts as $alias => $target) {
				$target = Strings::replace($target,"/","\\");
				Alias::set($target,$alias);
			}
		}
	}

	/**
	 * Get plugin path
	 */
	public static function getPath($alias)
	{
		return self::$infos[$alias]["path"];
	}

	/**
	 * Get core
	 */
	public static function getCore($alias,$param)
	{
		// die(var_dump(array($alias,$param)));
		// die(var_dump(self::$infos));
		if(self::isInfoKeyExist($alias,"core",$param)) 
		{
			return self::$infos[$alias]["core"][$param];
		}
		else return null;
	}
}