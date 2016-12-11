<?php 

namespace Vinala\Kernel\MVC\Controller;

use Vinala\Kernel\Http\Request;
use Vinala\Kernel\Validation\Validator;
use Vinala\Kernel\MVC\ORM;

/**
* Controller class
*/
class Controller
{
	
	//--------------------------------------------------------
	// Fucntions
	//--------------------------------------------------------

	/**
	* Validate a request
	*
	* @param Vinala\Kernel\Http\Request $request
	* @param array $rules
	* @return bool
	*/
	public static function validate(Request $request , array $rules)
	{
		$data = $request->all();

		return Validator::make($data , $rules);
	}

	
	
	
}