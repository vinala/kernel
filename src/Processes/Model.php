<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Filesystem\File;

/**
* Model class
*/
class Model
{
	public static function create($class , $table, $rt= null)
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
		$txt.="class $class extends ORM\n{\n\t/**\n\t* Name of the DataTable\n\t*/\n\tpublic ".'$_table'."='$table';\n\n}";
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