<?php 

namespace Vinala\Kernel\Cache\Exception;

use Vinala\Kernel\Logging\Exception;

/**
* Exception trowed when Cache Surface try to use Database surfaces
*/
class DatabaseSurfaceDisabledException extends Exception
{

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------
	function __construct() 
	{
		$this->message = 'The Database surface is disabled, the Cache surface can\'t use it.';
		
		$this->view = config('error.regular');
	}
}