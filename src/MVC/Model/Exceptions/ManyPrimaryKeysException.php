<?php 

namespace Lighty\Kernel\MVC\Model\Exception;

/**
* Directory not fount exception
*/
class ManyPrimaryKeysException extends \Exception{

	protected $message = "Pikia Framework doesn't support many primary keys in ine DataTable";   // exception message
	
}