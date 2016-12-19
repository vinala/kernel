<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Foundation\Application;

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

		if( ! file_exists($root."app/models/$file.php"))
		{
			$myfile = fopen($root."app/models/$file.php", "w");
			$txt = self::set($class , $table);

			fwrite($myfile, $txt);
			fclose($myfile);
			//
			return true;
		}
		
		return false;
	}

	public static function set($class , $table)
	{
		$txt = "<?php\n\nnamespace App\Model;\n\nuse Vinala\Kernel\MVC\ORM;\n\n";
		$txt.="class $class extends ORM\n{\n\t/**\n\t* Name of the DataTable\n\t*/\n\tpublic static ".'$_table'."='$table';\n\n}";
		//
		return $txt;
	}

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$models = glob(Application::$root."app/models/*.php");
		//
		return $models;
	}
}