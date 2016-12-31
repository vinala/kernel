<?php 

namespace Vinala\Kernel\Translator\Exception;

use Vinala\Kernel\Logging\Exception;

/**
* Language key not found exception
*/
class LanguageKeyNotFoundException extends Exception
{

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct($key = null) 
	{
		if(is_null($key)) 
		{
			$this->message = "The language Key you called not found";
		}
		else
		{
			$this->message = "There's no key language called '$key'";
		}

		$this->view = config('error.regular');

	}
}