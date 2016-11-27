<?php 

namespace Vinala\Kernel\Event\Exception;

use Vinala\Kernel\Logging\Exception;

/**
* Directory not fount exception
*/
class ManyListenersArgumentsException extends Exception
{
	function __construct() 
	{
		$this->message = "Couldn't use arguments for many listener trigger" ;
	}
}