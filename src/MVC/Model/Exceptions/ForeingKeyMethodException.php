<?php 

namespace Vinala\Kernel\MVC\ORM\Exception;

/**
* Directory not fount exception
*/
class ForeingKeyMethodException extends \Exception{

	function __construct($method,$model) {
		$this->message = "There is no methode call's '$method' in '$model' model ";
	}
	
}