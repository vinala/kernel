<?php

namespace Lighty\Kernel\MVC\View;

use Lighty\Kernel\MVC\View\Exception\ViewNotFoundException;
use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Plugins\Plugins;
use Lighty\Kernel\Atomium\Atomium;

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
		$_link2_=Application::$root.'app/views/'.$_name_.'.atom.php';
		$_link3_=Application::$root.'app/views/'.$_name_.'.tpl.php';
		//
		$_tpl_=false;
		$_tpl_ = 0;
		//
		if(file_exists($_link1_)) { $_link4_=$_link1_; $_tpl_=0; }
		else if(file_exists($_link2_)) { $_link4_=$_link2_; $_tpl_=1; }
		else if(file_exists($_link3_)) { $_link4_=$_link3_; $_tpl_=2; }
		else { throw new ViewNotFoundException($_name_); }

		if($_tpl_ == 1)
		{
			self::$showed="atomium";
			self::atomium($_link4_,$_data_);
		}
		elseif($_tpl_ == 2)
		{
			self::$showed="smarty";
			Template::show($_link4_,$_data_);
		}
		else
		{
			self::$showed="smpl";
			include($_link4_);
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
		$link2=Application::$root.'app/views/'.$name_fgdfgdf.'.atom.php';
		$link3=Application::$root.'app/views/'.$name_fgdfgdf.'.tpl.php';
		$link4='';
		//
		$tpl=false;
		//
		if(file_exists($link1)) { $link4=$link1; $tpl=0; }
		else if(file_exists($link2)) { $link4=$link2; $tpl=1; }
		else if(file_exists($link3)) { $link4=$link3; $tpl=2; }
		else { throw new ViewNotFoundException($name_fgdfgdf); }
		//
		//Show the output

		if($_tpl_ == 1)
		{
			self::$showed="atomium";
			self::atomium($link4,$data_kGdfgdf);
		}
		elseif($_tpl_ == 2)
		{
			self::$showed="smarty";
			Template::show($link4,$data_kGdfgdf);
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
		$_link2_=Application::$root.'app/views/'.$_name_.'.atom.php';
		$_link3_=Application::$root.'app/views/'.$_name_.'.tpl.php';
		//
		$_link1_=Plugins::getPath($_plg).Plugins::getCore($_plg,"views").'/'.$_name_.'.php';
		$_link2_=Plugins::getPath($_plg).Plugins::getCore($_plg,"views").'/'.$_name_.'.atom.php';
		$_link3_=Plugins::getPath($_plg).Plugins::getCore($_plg,"views").'/'.$_name_.'.tpl.php';
		//
		$_tpl_=0;
		//
		if(file_exists($_link1_)) { $_link4_=$_link1_; $_tpl_= 0 ; }
		else if(file_exists($_link2_)) { $_link4_=$_link2_; $_tpl_= 1 ; }
		else if(file_exists($_link3_)) { $_link4_=$_link3_; $_tpl_= 2 ; }
		else { throw new ViewNotFoundException($_name_); }

		if($_tpl_ = 1)
		{
			self::$showed="atomium";
			self::atomium($_link4_,$_data_);
		}
		else if($_tpl_ = 2)
		{
			self::$showed="smarty";
			Template::show($_link4_,$_data_);
		}
		else
		{
			self::$showed="smpl";
			include($_link4_);
		}
	}

	protected static function atomium($file, $_data_)
	{
		$atomium = new Atomium;
		return $atomium->show($file, $_data_);
	}


}
