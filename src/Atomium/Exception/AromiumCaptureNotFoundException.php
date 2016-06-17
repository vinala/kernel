<?php 

namespace Lighty\Kernel\Atomium\Exception;

/**
* Directory not fount exception
*/
class AromiumCaptureNotFoundException extends \Exception
{
	protected $message;
	//
	function __construct($capture, $view) 
	{
		$this->message = 'the capture "'.$capture.'" not found in "'.$view.'" view';
	}
}