<?php

namespace Fiesta\Core\MVC\View;

use Fiesta\Core\MVC\View\Exception\ViewNotFoundException;

/**
* View mother class
*/
class Views
{
	public static $showed;

	public static function make($_value_,$_data_=null)
	{
		if(!is_null($_data_))
		{
			foreach ($_data_ as $_key_ => $_value2_) {
				$$_key_=$_value2_;
			}
		}
		//getFile
		$_name_=str_replace('.', '/', $_value_);
		//
		$_link1_='../app/views/'.$_name_.'.php';
		$_link2_='../app/views/'.$_name_.'.tpl.php';
		//
		$_tpl_=false;
		//
		if(file_exists($_link1_)) { $_link3_=$_link1_; $_tpl_=false; }
		else if(file_exists($_link2_)) { $_link3_=$_link2_; $_tpl_=true; }
		else { throw new ViewNotFoundException($_name_); }

		if($_tpl_)
		{
			self::$showed="tpl";
			Template::show($_link3_,$_data_);
		}
		else
		{
			self::$showed="smpl";
			include($_link3_);
		}


	}

	public static function get($value_DGFSrtfg5,$data_kGdfgdf=null)
	{
		$name_fgdfgdf=str_replace('.', '/', $value_DGFSrtfg5);
		if(!is_null($data_kGdfgdf))
		{
			foreach ($data_kGdfgdf as $key => $value2) {
				$$key=$value2;
			}
		}
		//
		ob_start();    // start output buffering
		//get File
		//
		$name_fgdfgdf=str_replace('.', '/', $value_DGFSrtfg5);
		//
		$link1='../app/views/'.$name_fgdfgdf.'.php';
		$link2='../app/views/'.$name_fgdfgdf.'.tpl.php';
		$link3='';
		//
		$tpl=false;
		//
		if(file_exists($link1)) { $link3=$link1; $tpl=false; }
		else if(file_exists($link2)) { $link3=$link2; $tpl=true; }
		else { $link3=$name_fgdfgdf; $tpl=false; }
		//
		//Show the output
		if($tpl)
		{
			self::$showed="tpl";
			Template::show($link3,$data_kGdfgdf);
		}

		else
		{
			self::$showed="smpl";
			include($link3);
		}

		//
		$returned_value = ob_get_contents();    // get contents from the buffer
		ob_end_clean();
		//
		return $returned_value;
	}


}
