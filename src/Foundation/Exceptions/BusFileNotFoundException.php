<?php 

namespace Vinala\Kernel\Foundation\Exception;

/**
* Directory not fount exception
*/
class BusFileNotFoundException extends \Exception{

	protected $message;
	//
	function __construct($path) 
	{
        $this->message = "The Bus surface can't found the required file in '$path'";
	}
}