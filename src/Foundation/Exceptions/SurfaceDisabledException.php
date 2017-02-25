<?php 

namespace Vinala\Kernel\Foundation\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
* Surface Disabled Exception
*/
class SurfaceDisabledException extends Exception
{

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------
	function __construct($surface , $message = null) 
	{
		$this->message = is_null($message) ? "The $surface surface is disabled is component" : $message;
	}
}