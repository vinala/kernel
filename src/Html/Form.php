<?php 

namespace Vinala\Kernel\Html\Form ;

/**
* Form Class
*/
class Form
{

	/**
	* function to open the form
	*
	* @param array $options
	* @return string
	*/
	public static function open( array $options = array() )
	{
		// get the method passed in $options else use port
		$method = array_get($options, 'method', 'post');
		return ;
	}

	/**
	* function to set form method to upper 
	* and eccept ONLY get and post
	*
	* @param string $method
	* @return string
	*/
	protected static function getMethod($method)
	{
		$method = strtoupper($method);
		//
		return $method != "GET" ? "POST" : $method;
	}
	
	
}