<?php 

namespace Vinala\Kernel\Http;

/**
* Requests Class
*/
class Request
{
	

	/**
	* Data array contains request data
	*
	* @var array 
	*/
	protected $data = array() ;


	function __construct()
	{
		$this->data = $this->getData();

		$this->setProperties();
	}


	/**
	* Get resuest data
	*
	* @return array
	*/
	protected function getData()
	{
		return $_REQUEST;
	}

	/**
	* Set request data as class properties
	*
	* @return bool
	*/
	protected function setProperties()
	{
		foreach ($this->data as $key => $value) 
		{
			$this->$key = $value;
		}
	}
	
	

}
