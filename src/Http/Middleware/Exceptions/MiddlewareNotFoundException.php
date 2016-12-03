<?php 

namespace Vinala\Kernel\Http\Middleware\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
* Middleware not found exception
*/
class MiddlewareNotFoundException extends Exception
{

	function __construct($middleware)
	{
		$this->message = 'The middleware '.$middleware.' not found.';
	}

}