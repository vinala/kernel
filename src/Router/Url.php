<?php 

namespace Vianal\Kernel\Routing ;

use Vinala\Kernel\Objects\Strings;

/**
* The URL genarator class
*
* @version 1.0
* @author Youssef Had
* @package Vianal\Kernel\Routing
* @since v3.3.0
*/
class Url
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	//

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Genarte to Url 
	*
	* @param string $path
	* @param array $extra
	* @param bool $secure
	* @return string
	*/
	public static function to($path , $extra = [] , $secure = null)
	{
		
		return ;
	}

	/**
	* Check if Url is valid
	*
	* @param string $path
	* @return bool
	*/
	public static function isValidUrl($path)
	{
		if(Strings::startsWith($path,['#', '//', 'mailto:', 'tel:', 'http://', 'https://'])) {
            return true;
        }

        return filter_var($path, FILTER_VALIDATE_URL) !== false;
	}
	
	

}