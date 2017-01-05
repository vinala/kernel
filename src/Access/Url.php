<?php 

namespace Vinala\Kernel\Access;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Filesystem\File;

/**
* Url class
*/
class Url
{
	public static $css;
	public static $js;
	public static $img;

	public static function redirect($url)
	{
		$link="";
		if ($url[0] == "@") {
		    $link=Config::get('app.url').substr($url, 1);;
		    echo $link."<br>";
		    echo $url;
		}
		else
		{
			$link=$url;
		    echo $link;
		}
		header("location:".$link);
	}

	public static function ini()
	{
		self::$css=Application::$root."app/resources/css/";
		self::$js=Application::$root."app/resources/js/";
		self::$img=Application::$root."app/resources/images/";
	}


	/**
	* Get the route url of the app
	*
	* @return string
	*/
	public static function root()
	{
		$url = request('REQUEST_URI' , '' , 'server');
		$root = request('DOCUMENT_ROOT' , '' , 'server');

		$url = substr($url, 1);

		$parts = explode("/", $url);
		//
		$folder = "";
		//
		for ($i=0; $i < count($parts) ; $i++) 
		{
			if( File::isDirectory($root.$folder.$parts[$i]."/")) 
			{
				$folder .= $parts[$i]."/";
			}
			else
			{
				return $folder;
			}
		}
	}
	
}
