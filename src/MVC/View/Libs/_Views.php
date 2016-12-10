<?php 

namespace Vinala\Kernel\MVC ;

/**
* Views class
*/
class Views
{
	
	//--------------------------------------------------------
	// The properties
	//--------------------------------------------------------

	/**
	* The name of the view
	*
	* @var string 
	*/
	protected $name;


	/**
	* The path of the view
	*
	* @var string 
	*/
	protected $path;


	/**
	* Array od data passed to the view
	*
	* @var array 
	*/
	protected $data = array() ;
	

	//--------------------------------------------------------
	// constuctor
	//--------------------------------------------------------

	function __construct()
	{
		
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Call a view
	*
	* @param string $name
	* @param array $data
	* @return Vinala\Kernel\MVC\Views
	*/
	public function make( $name , $data = null)
	{
		//Merge data
		$this->data = array_collapse( $this->data , $data);

		$nameSegments = dot($name);
		
		return ;
	}


	
	
}