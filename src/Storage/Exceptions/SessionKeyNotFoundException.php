<?php 

namespace Vinala\Kernel\Storage\Exception;

use Vinala\Kernel\Logging\Exception;

/**
* Not Found Http Exception
*/
class SessionKeyNotFoundException extends Exception
{

	function __construct($key)
	{
		$this->message = 'The session variable '.$key.' not found';
		$this->view = config('error.regular');
	}
}