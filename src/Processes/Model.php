<?php 

namespace Pikia\Kernel\Process;

use Pikia\Kernel\Process\Process;

/**
* Model class
*/
class Model
{
	public static function create($fileName , $className , $tableName)
	{
		
		$class= $className;
		$file = $fileName;
		$table= $tableName;
		$root = Process::root;

		
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
		$txt = "<?php\n\nuse Pikia\Kernel\MVC\Model\Model;\n\n";
		$txt.="class $class extends Model\n{\n\t//Name of the table in database\n\tpublic static ".'$table'."='$table';\n\tprotected static ".'$foreignKeys=array();'."\n\n}";
		//
		return $txt;
	}
}