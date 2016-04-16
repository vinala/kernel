<?php

namespace Pikia\Kernel\MVC\View;

use Pikia\Kernel\MVC\View\Exception\ViewNotFoundException;
use Pikia\Kernel\Foundation\Application;
use Pikia\Kernel\Plugins\Plugins;

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
		$_link1_=Application::$root.'app/views/'.$_name_.'.php';
		$_link2_=Application::$root.'app/views/'.$_name_.'.tpl.php';
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
			\Connector::need($_link3_);
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
		$link1=Application::$root.'app/views/'.$name_fgdfgdf.'.php';
		$link2=Application::$root.'app/views/'.$name_fgdfgdf.'.tpl.php';
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
			\Connector::need($link3);
		}

		//
		$returned_value = ob_get_contents();    // get contents from the buffer
		ob_end_clean();
		//
		return $returned_value;
	}

	/**
	 * View For Plugin
	 */
	public static function import($_plg,$_value_,$_data_=null)
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
		$_link1_=Application::$root.'app/views/'.$_name_.'.php';
		$_link2_=Application::$root.'app/views/'.$_name_.'.tpl.php';
		//
		$_link1_=Plugins::getPath($_plg).Plugins::getCore($_plg,"views").'/'.$_name_.'.php';
		$_link2_=Plugins::getPath($_plg).Plugins::getCore($_plg,"views").'/'.$_name_.'.tpl.php';
		// die($_link1_);
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
			\Connector::need($_link3_);
		}


	}


}
