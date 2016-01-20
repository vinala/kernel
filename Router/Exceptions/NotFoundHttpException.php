<?php 

namespace Fiesta\Core\Router\Exception;

/**
* Route Exception
*/
class NotFoundHttpException extends \Exception
{
	protected $message;   // exception message

	function __construct() 
	{
		$this->message="Sorry, the page you are looking for could not be found.";
	}
}