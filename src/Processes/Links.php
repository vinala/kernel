<?php 

namespace Lighty\Kernel\Process;

use Lighty\Kernel\Process\Process;
use Lighty\Kernel\Objects\DateTime as Time;
use Lighty\Kernel\Foundation\Application;

/**
* Link class
*/
class Links
{
	public static function create($name)
	{
		$time = Time::now();
		if(empty($name)) $name=$time;
		//
		$Root = Process::root;
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
		$txt.="/*\n\tlinks of ".$name."\n*/\n\n";
		$txt .= "return array(\n\t'link_name_1' => 'link_value_1',\n\t'link_name_2' => 'link_value_2'\n);";
		$txt .= "\n\n?>";

		return $txt;
	}

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$links = glob(Application::$root."app/links/*.php");
		//
		return $links;
	}
}