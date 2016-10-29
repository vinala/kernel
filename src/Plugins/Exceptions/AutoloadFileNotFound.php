<?php 

namespace Vinala\Kernel\Plugins\Exception;

/**
* Directory not fount exception
*/
class AutoloadFileNotFoundException extends \Exception
{
	protected $message;
	//
	function __construct($path) 
	{
		$this->message="Plug-in autoload file not found in '$path'";
	}
}