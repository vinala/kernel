<?php 

namespace Vinala\Kernel\Surfaces ;

//use SomeClass;

/**
* Class to get surefaces accessors
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Surfaces
* @since v3.3.0
*/
class Accessor
{


	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Redirect surface accessor
	*
	* @return string
	*/
	public static function redirect()
	{
		return \Vinala\Kernel\Access\Redirect::class;
	}
	

}