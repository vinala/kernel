<?php 

namespace Fiesta\Kernel\Plugins;

use Fiesta\Kernel\Foundation\Application;
use Fiesta\Kernel\Filesystem\Filesystem;
use Fiesta\Kernel\Plugins\Exception\AutoloadFileNotFound;
use Fiesta\Kernel\Objects\Strings;

/**
* 
*/
class Plugins
{
	/**
	 * All info about plugins
	 */
	protected static $infos = array();

	public static function ini()
	{
		// \Http::clear();
		self::getInfo();
		//
		self::req();
		// die();
	}

	protected static function req()
	{
		foreach (self::$infos as $key => $value) {
			// include $value["path"]."/".$value["autoload"]["file"];
			self::call($value);
			self::exec($value);
		}
	}

	protected static function getInfo()
	{
		$files = self::getFiles();
		//
		foreach ($files as $path) {
			$data = self::convert(self::readFile($path."/.info"));
			$data['path']=$path;
			self::$infos[$data["alias"]]=$data;

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
}