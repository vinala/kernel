<?php 

namespace Vinala\Kernel\Process\Exception;

/**
* Directory not fount exception
*/
class TranslatorFolderNeededException extends \Exception
{
	protected $message;
	//
	function __construct($file) 
	{
		$this->message="Translator folder to put $file file not found";
	}
}