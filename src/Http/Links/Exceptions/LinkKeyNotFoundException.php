<?php 

namespace Vinala\Kernel\Http\Links\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
* Middleware not found exception
*/
class LinkKeyNotFoundException extends Exception
{

	function __construct($key)
	{
		$this->message = "The link key '".$key."' not found.";
	}

}