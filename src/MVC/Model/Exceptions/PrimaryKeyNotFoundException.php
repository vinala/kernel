<?php 

namespace Pikia\Kernel\MVC\Model\Exception;

/**
* Directory not fount exception
*/
class PrimaryKeyNotFoundException extends \Exception
{
	function __construct($table) {
		$this->message = "Primary key not found in $table table ";
	}
	
}