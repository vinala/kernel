<?php 

namespace Fiesta\Core\Translator\Exception;

/**
* Directory not fount exception
*/
class LanguageKeyNotFoundException extends \Exception
{
	protected $message = "The language Key you called not found";   // exception message

	function __construct($key=null) {
		if(is_null($key)) $this->message="The language Key you called not found";
		else $this->message="There's no key language called '$key'";
	}
}