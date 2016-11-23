<?php 

namespace Vinala\Kernel\Logging;

use Exception as E;

/**
* Main Exception for Vinala default excpetion
*/
class Exception extends E
{


	/**
	* The view name to show if debugging mode was off
	*
	* @var string
	*/
	public $view ;


	function __construct($view = null , $message = "" , $code = 0 , $previous = NULL)
	{
		$this->view = $view;
	}
	

}
