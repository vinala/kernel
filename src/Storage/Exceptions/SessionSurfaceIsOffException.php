<?php 

namespace Vinala\Kernel\Storage\Exception;

use Vinala\Kernel\Logging\Exception;

/**
* Not Found Http Exception
*/
class SessionSurfaceIsOffException extends Exception
{

	function __construct($key)
	{
		$this->message = 'The session surface is not enabled';
		$this->view = config('error.regular');
	}
}