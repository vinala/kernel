<?php 

namespace Lighty\Kernel\Database\Exceptions;

use Lighty\Kernel\Database\Database;

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