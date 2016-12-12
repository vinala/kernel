<?php 

namespace Vinala\Kernel\Access ;

//use SomeClass;

/**
* Redirect class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Access
* @since v3.3.0
*/
class Redirect 
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	//

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Redirect to previous location
	*
	* @return mixed
	*/
	public function back()
	{
		return header('Location: javascript://history.go(-1)');
	}
	

}