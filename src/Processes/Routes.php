<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Objects\Strings;

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

	protected static function traitGet($route)
	{
		$content = "";
		//
		$content.="\n\n".self::func($route)."\n";
		$content.='{'."\n";
		$content.="\t".'//'."\n";
		$content.='});';
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
	 * Set the header of the function
	 */
	protected static function func($route)
	{
		$params = self::dynamic($route);
		//
		if(count($params)>0) return 'Route::get("'.$route.'",function('.self::formatParams($params).')';
		else return 'Route::get("'.$route.'",function()';
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
        for ($i=0; $i < Strings::lenght($route); $i++) 
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