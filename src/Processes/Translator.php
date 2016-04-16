<?php 

namespace Pikia\Kernel\Process;

use Pikia\Kernel\Process\Process;

/**
* Language class
*/
class Translator
{
	public static function createDir($name)
	{
		$root = Process::root;
		//
		if( ! file_exists($root."app/lang/".$name))
		{
			mkdir ($root."app/lang/".$name);
			return true;
		}
		else return false;
	}

	public static function createFile($dirName , $fileName)
	{
		$root = Process::root;
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
}