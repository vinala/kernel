<?php 

namespace Vinala\Kernel\Http\Links;

use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Http\Links\Exceptions\LinkKeyNotFoundException;

/**
* The Link surface
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Http\Links
* @since v1.0.0
*/
class Link
{


	//--------------------------------------------------------
	// Proprties
	//--------------------------------------------------------


	/**
	* The list of links
	*
	* @var array 
	*/
	private static $links = [] ;
	


	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Initiate the Links surface
	*
	* @return null
	*/
	public static function ini()
	{
		$files = glob(root().'app/links/*.php');

		foreach ($files as $file) {
			
			$table = need($file);

			foreach ($table as $key => $value) 
			{
				$file = static::getFileName($file);

				self::$links[$file][$key] = $value;
			}
		}
	}

	/**
	* Get the link by dotted key
	*
	* @param string $key
	* @return string
	*/
	public static function get($key)
	{
		exception_if(! array_has(self::$links , $key) , LinkKeyNotFoundException::class , $key);
		dc(self::$links);
		return array_get(self::$links , $key);
	}

	/**
	* Check if the link key exists
	*
	* @param string $key
	* @return bool
	*/
	public static function exists($key)
	{
		return array_has(self::$links , $key);
	}

	/**
	* Set a new link value in runtime
	*
	* @param string $key
	* @param string $link
	* @return null
	*/
	public static function set($key , $value)
	{
		$segements = dot($key);

		if(count($segements) == 2)
		{
			self::$links[$segements[0]][$segements[1]] = $value;
		}
		else
		{
			exception(LogicException::class , 'The link surface doesn\'t support many indexes');
		}
		return ;
	}
	

	public static function popup($link='',$title="",$width=200,$height=100)
	{
		echo ('onclick="window.open(\''.$link.'\', \''.$title.'\', \'width='.$width.', height='.$height.',top=\'+top+\', left=\'+left+\')"') ;
	}


	/**
	* Get file name
	*
	* @param $path
	* @return string
	*/
	private static function getFileName($path)
	{
		return File::name($path);
	}
	
}