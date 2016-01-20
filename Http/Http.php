<?php 

namespace Fiesta\Core\Http;

/**
* HTTP Class
*/
class Http
{
	/**
	 * To exit compilation and show string
	 */
	public static function abort($string = "")
	{
		die($string);
	}

	/**
	 * To start recording the echoed data
	 */
	public static function start()
	{
		ob_start();
	}


	/**
	 * To clear screen from echoed data
	 */
	public static function clear()
	{
		ob_end_clean();
	}
}