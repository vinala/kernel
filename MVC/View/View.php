<?php

namespace Fiesta\Core\MVC\View;

/**
* View mother class
*/
class View
{


	public static function make($value,$data=null)
	{
		Views::make($value,$data);
	}

	public static function get($value,$data=null)
	{
		return Views::get($value,$data);
	}


}
