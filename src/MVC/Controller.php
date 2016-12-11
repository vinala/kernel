<?php 

namespace Vinala\Kernel\MVC;

use Vinala\Kernel\Http\Request;
use Vinala\Kernel\Validation\Validator;
use Vinala\Kernel\MVC\ORM;

/**
* Controller class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\MVC
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

	/**
	* Set each properties of model from request
	*
	* @param Vinala\Kernel\MVC\ORM $model
	* @param Vinala\Kernel\Http\Request $request
	* @param array $data
	* @return Vinala\Kernel\MVC\ORM
	*/
	public static function each(ORM &$model , Request $request , $data = null)
	{
		if( ! is_null($data))
		{
			foreach ($data as $key) 
			{
				$model->$key = $request->$$key;
			}
		}
		else
		{
			foreach ($request->all() as $key => $value) 
			{
				if(in_array($key, $model->_columns))
				{
					$model->$key = $request->$key;
				}
			}
		}
	}
	
	
	
}