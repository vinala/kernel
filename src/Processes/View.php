<?php 

namespace Lighty\Kernel\Process;

use Lighty\Kernel\Process\Process;
use Lighty\Kernel\Objects\DateTime as Time;

/**
* View class
*/
class View
{
	protected static function replace($name)
	{
		return str_replace(":", "/", $name);
	}
	public static function create($name , $isSmarty, $rt= null)
	{
		$file	=	self::replace($name);
		$pos 	= 	strpos($file, "/");
		$Root = is_null($rt) ? Process::root : $rt ;
		if($pos)
		{
			$structure 	=   $Root."app/views/".$file[0]."/";
			//
			if(mkdir($structure, 0777, true)) 
			{
				$file		= 	explode("/", $file);
				$extention = $isSmarty ? ".tpl.php" : ".php";
				//
				return self::CreatView($file[1], $Root."app/views/".$file[0]."/", $extention);
			}
			else return 3;
		}
		else
		{
			$extention = $isSmarty ? ".tpl.php" : ".php";
			//
			return self::CreatView($file, $Root."app/views/", $extention);
		}

	}

	protected static function CreatView($file, $path, $ext)
	{
		if( ! file_exists($path."$file$ext"))
		{
			$myfile = fopen($path."$file$ext", "w");
			//
			$txt = self::set($ext , $file);
			//
			fwrite($myfile, $txt);
			fclose($myfile);
			//
			return 1;
		}
		else return 2;
	}

	protected static function set($ext , $file)
	{
		return 
			($ext == '.tpl.php') ? 
				"{* View file  : $file *} \n"
			: "<?php\n\n/**\n* View file  : $file\n*/\n\n";
	}
}