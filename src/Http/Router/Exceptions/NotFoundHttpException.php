<?php 

namespace Vinala\Kernel\Http\Router\Exceptions;

use Vinala\Kernel\Logging\Exception;

/**
* Not Found Http Exception
*/
class NotFoundHttpException extends Exception
{

	function __construct()
	{
		$this->message = 'Sorry, the page you are looking for could not be found.';
		$this->view = config('error.404');
	}
}