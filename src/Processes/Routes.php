<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\String\Strings;

/**
* Controller class
*/
class Router
{
	public static function get($route)
	{
		$content = self::traitGet($route);
		//
		self::addRoute($content);
		return true;
	}

	/**
	* function to generate Post Route
	*
	* @param string $route
	* @return bool
	*/
	public static function post($route)
	{
		$content = self::traitPost($route);
		//
		self::addRoute($content);
		return true;
	}

	/**
	* function to generate target Route
	*
	* @param string $route
	* @param string $controller
	* @param string $method
	* @return bool
	*/
	public static function target($route , $controller , $method)
	{
		$content = self::traitTarget($route , $controller , $method);
		//
		self::addRoute($content);
		return true;
	}

	protected static function traitGet($route)
	{
		$content = "";
		//
		$content.="\n\n".self::funcGet($route)." ";
		$content.='{'."\n";
		$content.="\t".'// do something'."\n";
		$content.='});';
		//
		return $content;
	}

	/**
	* generate Post Route script
	*
	* @param string $route 
	* @return string
	*/
	protected static function traitPost($route)
	{
		$content = "";
		//
		$content.="\n\n".self::funcPost($route)." ";
		$content.='{'."\n";
		$content.="\t".'// do something'."\n";
		$content.='});';
		//
		return $content;
	}

	/**
	* generate CAll Route script
	*
	* @param string $route
	* @param string $controller
	* @param string $method
	* @return string
	*/
	protected static function traitTarget($route , $controller , $method)
	{
		$content = "\n\ntarget('$route','$controller@$method');";
		//
		return $content;
	}

	/**
	 * Add callable to the route file
	 */
	protected static function addRoute($content)
	{
		$Root = Process::root;
		$RouterFile 	= $Root."app/http/Routes.php";
		//
		file_put_contents($RouterFile, $content, FILE_APPEND | LOCK_EX);
	}

	/**
	 * Set the header of the get function
	 */
	protected static function funcGet($route)
	{
		$params = self::dynamic($route);
		//
		if(count($params)>0) return 'get(\''.$route.'\',function('.self::formatParams($params).')';
		else return 'get(\''.$route.'\',function()';
	}

	/**
	 * Set the header of the get function
	 *
	 * @param string $route
	 */
	protected static function funcPost($route)
	{
		$params = self::dynamic($route);
		//
		if(count($params)>0) return 'post(\''.$route.'\',function('.self::formatParams($params).')';
		else return 'post(\''.$route.'\',function()';
	}

	/**
	 * Concat the paramters
	 */
	protected static function formatParams($params)
	{
		$reslt = "";
		//
		for ($i=0; $i < count($params); $i++) { 
			$reslt.= "$".$params[$i];
			if($i < count($params)-1) $reslt.=",";
		}
		return $reslt;
	}

	/**
	 * Get the dynamic paramteres from route string
	 */
	protected static function dynamic($route)
    {
        $parms = array();
        $param = "";
        $open = false;
        //
        for ($i=0; $i < Strings::length($route); $i++) 
        {

            if($open && $route[$i] != "}") $param .= $route[$i];
            //
            if($route[$i] == "{" && !$open)  $open = true;
            //
            elseif ( $route[$i] == "}" && $open ) 
            {
                $open = !true;
                $parms[] = $param;
                $param = "";
            }
        }
        //
        return $parms;
    }

}