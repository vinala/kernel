<?php 

namespace Vinala\Kernel\Database\Exceptions;

use Vinala\Kernel\Database\Database;

/**
* Directory not fount exception
*/
class QueryException extends \Exception
{
	protected $message;
	//
	function __construct() 
	{
		$this->message = Database::execerr();
	}
}