<?php 

namespace Fiesta\Kernel\Plugins\Exception;

/**
* Directory not fount exception
*/
class AutoloadFileNotFound extends \Exception
{
	protected $message;
	//
	function __construct($path) 
	{
		$this->message="Plug-in autoload file not found in '$path'";
	}
}