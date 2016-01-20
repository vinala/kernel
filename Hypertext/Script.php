<?php 

/**
* scripts
*/
class Script
{
	public static function make($_name_)
	{
		$_name_=str_replace(".", "/", $_name_);
		include "../app/scripts/".$_name_.".php";
	}
}