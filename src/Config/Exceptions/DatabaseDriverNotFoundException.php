<?php 

namespace Vinala\Kernel\Config\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
* Classv Aliased Not Found Exception
*/
class DatabaseDriverNotFoundException extends Exception
{

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------
	function __construct($driver) 
	{
		$this->message = "The driver '$driver' in database config file not found";
	}
}