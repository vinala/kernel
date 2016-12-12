<?php 

namespace Vinala\Kernel\Cubes ;

//use SomeClass;

/**
* Class to get cubes accessors
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