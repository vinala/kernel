<?php 

namespace Vinala\Kernel\Html ;

/**
* Form Class
*/
class Form
{

	protected $reserved = array('method' , 'action' , 'url' , 'charset' , 'files');

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
		$attributes['method'] = $this->getMethod($method);
		
		$attributes['action'] = array_get($options, 'url' , '');
		$attributes['accept-charset'] = array_get($options, 'charset' , 'UTF-8');
		//
		//PUT and PATCH and DELETE
		//
		//if form use files
		if (isset($options['files']) && $options['files'])
		{
			$options['enctype'] = 'multipart/form-data';
		}
		
		$attributes = array_merge(
			$attributes, array_except($options, $this->reserved)
		);
		
		$attributes = Html::attributes($attributes);

		return '<form'.$attributes.'>';
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