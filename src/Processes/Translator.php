<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Objects\Strings;
use Vinala\Kernel\Objects\DateTime;
use Vinala\Kernel\Filesystem\File;

use Vinala\Kernel\Process\Exception\TranslatorFolderNeededException;
use Vinala\Kernel\Process\Exception\TranslatorManyFolderException;

/**
* Language class
*/
class Translator
{

	public static function create($name, $rt = null)
	{
		$root = is_null($rt) ? Process::root : $rt ;
		//
		$file	=	self::replace($name);
		$folders = Strings::splite($file,"/");
		//
		$file = self::createFolders($folders, $root);
		//
		return self::createFile($file["file"], $file["path"]);
	}

	public static function replace($name)
	{
		return str_replace(".", "/", $name);
	}

	protected static function createFolders($folders, $root)
	{
		$initPath = $path = $root."resources/translator/";
		//
		if(count($folders) > 2) throw new TranslatorManyFolderException();
		//
		for ($i=0; $i < count($folders)-1 ; $i++)
		{
			$value = $folders[$i];
			//
			if(is_dir($path.$value))
				$path .= $value."/";
			else
			{
				$path .= $value."/";
				mkdir($path, 0777, true);
			}
		}
		$file = $folders[count($folders)-1];
		//
		if($path == $initPath) throw new TranslatorFolderNeededException($file);
		//
		return array("path" => $path, "file" => $file );
	}

	public static function createFile($file, $path)
	{
		if( ! File::exists("$path$file.php"))
		{
			File::put("$path$file.php" , self::set($file));

			return true;
		}
		else return false;
	}

	public static function set($file)
	{
		$txt = "<?php\n\n";
		$txt .= "/**\n* $file translator\n*\n* @author ".config('app.owner')."\n";
		$txt .= "* creation time : ".DateTime::now().' ('.time().')'."\n";
		$txt .= "**/\n\n";
		$txt .= 'return'." [\n\t // 'key' => 'value',\n];";
		
		return $txt;
	}

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$data = array();
		//
		$folders = glob(Application::$root."resources/translator/*");
		//
		foreach ($folders as $key => $value) {
			$folder = \Strings::splite($value , "resources/translator/");
			$folder = $folder[1];
			//
			$data[] = ">".$folder;
			//
			foreach (glob(Application::$root."resources/translator/".$folder."/*.php") as $key2 => $value2) {
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