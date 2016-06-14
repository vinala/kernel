<?php 

namespace Lighty\Kernel\Process\Exception;

/**
* Directory not fount exception
*/
class TranslatorManyFolderException extends \Exception
{
	protected $message;
	//
	function __construct() 
	{
		$this->message="Lighty can't detect sub folder in languages folder, use only one folder : \n'folder.file'";
	}
}