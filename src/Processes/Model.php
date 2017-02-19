<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Objects\DateTime;

/**
* Model class
*/
class Model
{
	public static function create($class , $table , $rt= null)
	{
		$class = ucfirst($class);
		
		$file = $class;

		$root = is_null($rt) ? Process::root : $rt ;

		$path = $root."resources/models/$file.php";

		if( ! File::exists($path))
		{
			File::put($path , self::set($class , $table));
			//
			return true;
		}
		
		return false;
	}

	public static function set($class , $table)
	{
		$txt = "<?php\n\nnamespace App\Model;\n\nuse Vinala\Kernel\MVC\ORM;\n\n";
		$txt .= "/**\n* ".$class." Model\n*\n* @author ".config('app.owner')."\n";
		$txt .= "* creation time : ".DateTime::now().' ('.time().')'."\n";
		$txt .= "**/\n";
		$txt .= "class $class extends ORM\n{";
		$txt .= "\n\n\t/**\n\t* The name of the DataTable\n\t*\n\t* @param string\n\t*/";
		$txt .= "\n\tpublic ".'$_table'." = '$table';\n\n}";
		//
		return $txt;
	}

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$models = glob(root()."resources/models/*.php");
		//
		return $models;
	}
}