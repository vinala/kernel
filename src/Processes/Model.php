<?php 

namespace Lighty\Kernel\Process;

use Lighty\Kernel\Process\Process;
use Lighty\Kernel\Foundation\Application;

/**
* Model class
*/
class Model
{
	public static function create($fileName , $className , $tableName, $rt= null)
	{
		
		$class= $className;
		$file = $fileName;
		$table= $tableName;
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
			else return false;
	}

	public static function set($class , $table)
	{
		$txt = "<?php\n\nuse Lighty\Kernel\MVC\Model\Model;\n\n";
		$txt.="class $class extends Model\n{\n\t//Name of the table in database\n\tpublic static ".'$table'."='$table';\n\tprotected static ".'$foreignKeys=array();'."\n\n}";
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