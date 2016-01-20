<?php 

namespace Fiesta\Core\MVC\Relations\Exception;

/**
* Directory not fount exception
*/
class ModelNotFindedException extends \Exception{
	function __construct( $model) {
		$this->message = "The '$model' model not found";
	}
}