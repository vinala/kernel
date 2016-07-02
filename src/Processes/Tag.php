<?php 

namespace Lighty\Kernel\Process;

use Lighty\Kernel\Process\Process;
use Lighty\Kernel\Foundation\Application;

/**
* Controller class
*/
class Tag
{
	public static function create($class, $target, $tag, $write = false)
	{
		$Root = Process::root;
		//
		if(!file_exists($Root."app/tags/$class.php")){
			$myfile = fopen($Root."app/tags/$class.php", "w");
			$txt = self::set($class, $target, $tag, $write);
			fwrite($myfile, $txt);
			fclose($myfile);
			//
			return true;
		}
		else return false;

	}

	protected static function set($class, $target, $tag, $write =false)
	{
		$txt = "<?php\n\nnamespace Lighty\Kernel\Atomium\User;\n\n";
		$txt .= "use Lighty\Kernel\Atomium\UserCompiler\AtomiumUserTags;\n\n";
		$txt.="\n\nclass $class extends AtomiumUserTags\n{\n\t";

		$txt.="\n\t/**\n\t * The function that Atomium should replace it.\n\t *\n\t * @var string\n\t */\n\tprotected static ".'$target = '.'"'.$target.'"'.";\n\n";
		$txt.="\n\t/**\n\t * The tag that Atomium should replace it by the function.\n\t *\n\t * @var string\n\t */\n\tprotected static ".'$tag = '.'"'.$tag.'"'.";\n\n";
		if($write)
		$txt.="\n\t/**\n\t * If set true Atomium will echo the returned value from the function.\n\t *\n\t * @var string\n\t */\n\tprotected static ".'$write = '.'"'.$write.'"'.";\n\n";
		$txt.="\n}";
		return $txt;
	}

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$commands = glob(Application::$root."app/tags/*.php");
		//
		return $commands;
	}
}