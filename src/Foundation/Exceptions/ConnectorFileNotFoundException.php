<?php 

namespace Lighty\Kernel\Foundation\Exception;

/**
* Directory not fount exception
*/
class ConnectorFileNotFoundException extends \Exception{

	protected $message;
	//
	function __construct($path="") 
	{
		$this->message="Connector required in '$path' not found";
	}
}