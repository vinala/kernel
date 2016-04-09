<?php 

namespace Fiesta\Kernel\MVC\Relations\Exception;

/**
* Directory not fount exception
*/
class ModelNotFindedException extends \Exception{
	function __construct( $model) {
		$this->message = "The '$model' model not found";
	}
}