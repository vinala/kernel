<?php

namespace Vinala\Kernel\String\Exception;

use Vinala\Kernel\Logging\Exception;

/**
* String Out Index Exception
*/
class StringOutIndexException extends Exception
{

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------
	function __construct() 
	{
		$this->message = 'The index is out of string range';		
	}
}
