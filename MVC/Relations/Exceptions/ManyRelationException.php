<?php 

namespace Fiesta\Core\MVC\Relations\Exception;

/**
* Directory not fount exception
*/
class ManyRelationException extends \Exception{

	function __construct( $localModel , $remoteModel) {
		$this->message = "The $localModel and $remoteModel have more then one relation";
	}
	
}