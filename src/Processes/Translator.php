<?php 

namespace Lighty\Kernel\Process;

use Lighty\Kernel\Process\Process;
use Lighty\Kernel\Foundation\Application;

/**
* Language class
*/
class Translator
{
	public static function createDir($name, $rt = null)
	{
		$root = is_null($rt) ? Process::root : $rt ;
		//
		if( ! file_exists($root."app/lang/".$name))
		{
			mkdir ($root."app/lang/".$name);
			return true;
		}
		else return false;
	}

	public static function createFile($dirName , $fileName, $rt = null)
	{
		$root = is_null($rt) ? Process::root : $rt ;
		//
		if(!file_exists($root."app/lang/$dirName/$fileName.php"))
			{
				$myfile = fopen($root."app/lang/$dirName/$fileName.php", "w");
				$txt = self::set();
				//
				fwrite($myfile, $txt);
				fclose($myfile);
				//
				return true;
			}
			else return false;
	}

	public static function set()
	{
		return "<?php\n\nreturn array(\n\t'var_lan_name_1' => 'var_lang_value_1',\n\t'var_lan_name_2' => 'var_lang_value_2'\n);";
	}

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$data = array();
		//
		$folders = glob(Application::$root."app/lang/*");
		//
		foreach ($folders as $key => $value) {
			$folder = \Strings::splite($value , "app/lang/");
			$folder = $folder[1];
			//
			$data[] = ">".$folder;
			//
			foreach (glob(Application::$root."app/lang/".$folder."/*.php") as $key2 => $value2) {
				$file = \Strings::splite($value2 , "app/lang/$folder/");
				$file = $file[1];
				//
				$data[] = "   ".$file;
			}
		}
		//
		return $data;
	}
}