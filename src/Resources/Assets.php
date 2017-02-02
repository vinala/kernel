<?php

namespace Vinala\Kernel\Resources;

use Vinala\Kernel\Access\Path;

/**
* The web assets surface
*
* @version 1.1.0
* @author Youssef Had
* @package Vinala\Kernel\Resources
* @since v1.0.0
*/
class Assets
{

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Call CSS files
	*
	* @param string|array $files
	* @param bool $nest
	* @return string
	*/
	public static function css( $files , $nest = true)
	{
		if(is_array($files))
		{
			foreach ($files as $file) 
			{
				self::cssCall($file , $nest);
			}
		}
		elseif(is_string($files))
		{
			self::cssCall($files , $nest);
		}
	}

	/**
	* The process to CSS HTML Tag
	*
	* @param string $file
	* @param bool $nest
	* @return null
	*/
	public static function cssCall($file , $nest)
	{
		if (strpos($file,'http://') !== false) 
		{
		    $path = $file.'.css';
		}
		else
		{
			if($nest)
			{
				$file = str_replace('.', '/', $file);
				$path = path().'assets/css/'.$file.'.css';
			}
			else
			{
				$path = $file;
			}
		}

		self::cssTag($path);
	}
	

	/**
	* CSS call
	*
	* @param string $path
	* @return null
	*/
	private static function cssTag($path)
	{
		echo '<link rel="stylesheet" type="text/css" href="'.$path.'">'."\n";
	}


	/**
	* Call JS files
	*
	* @param string|array $files
	* @param bool $nest
	* @return string
	*/
	public static function js( $files , $nest = true)
	{
		if(is_array($files))
		{
			foreach ($files as $file) 
			{
				self::jsCall($file , $nest);
			}
		}
		elseif(is_string($files))
		{
			self::jsCall($files , $nest);
		}
	}

	/**
	* The process to JS HTML Tag
	*
	* @param string $file
	* @param bool $nest
	* @return null
	*/
	public static function jsCall($file , $nest)
	{
		if (strpos($file,'http://') !== false) 
		{
		    $path = $file.'.js';
		}
		else
		{
			if($nest)
			{
				$file = str_replace('.', '/', $file);
				$path = 'assets/js/'.$file.'.js';
			}
			else
			{
				$path = $file;
			}
		}

		self::jsTag($path);
	}
	

	/**
	* JS call
	*
	* @param string $path
	* @return null
	*/
	private static function jsTag($path)
	{
		echo '<script type="text/javascript"  src="'.$path.'"></script>'."\n";
	}

}