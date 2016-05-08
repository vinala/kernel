<?php 

namespace Pikia\Kernel\Plugins;

use Pikia\Kernel\Foundation\Application;
use Pikia\Kernel\Filesystem\Filesystem;
use Pikia\Kernel\Plugins\Exception\AutoloadFileNotFoundException;
use Pikia\Kernel\Plugins\Exception\InfoStructureException;
use Pikia\Kernel\Objects\Strings;
use Pikia\Kernel\Config\Alias;

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
			$data = self::convert(self::readFile($path."/pikia.json"),$path);
			$data = $data['system'];
			$data['path']=$path;

				if(array_key_exists("alias", $data)) self::$infos[$data["alias"]]=$data;
				else 
				{
					// die($path."/.info");
				}
		}
		//
		return self::$infos;
	}

	protected static function getConfig()
	{
		$files = self::getFiles();
		//
		foreach ($files as $path) {
			$data = self::convert(self::readFile($path."/pikia.json"),$path);
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
	protected static function convert($string,$path)
	{
		$data = json_decode($string,true);
		//
		if(json_last_error() == JSON_ERROR_SYNTAX)
		{
			throw new InfoStructureException($path);
		} 
		//
		return $data;
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
		if((new Filesystem())->exists($file)) \Connector::need($file);
		else throw new AutoloadFileNotFoundException($file);
		

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
	public static function setAlias($alias)
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
		if(self::isInfoKeyExist($alias,"core",$param)) 
		{
			return self::$infos[$alias]["core"][$param];
		}
		else return null;
	}

	public static function getCoreParams($alias,$param)
	{
		return self::getCore($alias,$param);
	}
}