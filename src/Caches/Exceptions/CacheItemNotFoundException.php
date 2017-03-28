<?php 

namespace Vinala\Kernel\Caches\Exception;

use Vinala\Kernel\Logging\Exception;

/**
* Authentication Fields Not Found Exception
*/
class CacheItemNotFoundException extends Exception
{

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------
	function __construct($item) 
	{
		$this->message = "The Cache item '$item' not found";
		
		$this->view = config('error.regular');
	}
}