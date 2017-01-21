<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Objects\DateTime as Time;
use Vinala\Kernel\Foundation\Application;

/**
* Link class
*/
class Links
{
	public static function create($name, $rt = null)
	{
		$time = Time::now();
		if(empty($name)) $name=$time;
		//
		$Root = is_null($rt) ? Process::root : $rt ;
		if(!file_exists($Root."app/links/".$name.".php"))
		{
			$myfile = fopen($Root."app/links/".$name.".php", "w");
			$txt = self::set($name);
			fwrite($myfile, $txt);
			fclose($myfile);
			//
			return true;
		}
		else return false;
	}

	public static function set($name)
	{
		$txt = "<?php\n\n";
		$txt.="/**\n* links of ".$name."\n*\n* @var array \n*/\n";
		$txt .= "return [\n\t//\n];";

		return $txt;
	}

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$links = glob(roo()."app/links/*.php");
		//
		return $links;
	}
}