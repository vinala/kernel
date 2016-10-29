<?php 

namespace Vinala\Kernel\Database\Schema\Exception;

/**
* Directory not fount exception
*/
class SchemaTableExistsException extends \Exception
{
	function __construct($table) 
	{
		$this->message = "The table '$table' already exists";
	}
}