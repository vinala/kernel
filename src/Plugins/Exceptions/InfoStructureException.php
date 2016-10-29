<?php 

namespace Vinala\Kernel\Plugins\Exception;

/**
* Directory not fount exception
*/
class InfoStructureException extends \Exception
{
	protected $message;
	//
	function __construct($plugin) 
	{
		$this->message=".info file structure '$plugin' is not identical to the framework";
	}
}