<?php 

namespace Lighty\Kernel\Process;

use Lighty\Kernel\Database\Seeder;
use Lighty\Kernel\Foundation\Application;

/**
* Seeds class
*/
class Seeds
{

	public static function exec()
	{
		return Seeder::ini();
	}

	public static function add($name,$table)
	{
		$nom=$name;
		$Root = Process::root;
		//
		if(!file_exists($Root."database/seeds/$nom.php"))
		{
		 	$myfile = fopen($Root."database/seeds/$nom.php", "w");
			$txt = self::set($nom,$table);
			//
			fwrite($myfile, $txt);
			fclose($myfile);
			//
			return true;
		}
		else return false;
	}

	public static function set($nom,$table)
	{
		$txt = "<?php\n\nuse Lighty\Kernel\Database\Seeder;\n\n";
		$txt.="/**\n* class de seeder $nom\n*/\n\nclass $nom extends Seeder\n{\n";

		//datatable name
		$txt.="\t/*\n\t* Name of DataTable\n\t*/\n\tpublic ".'$table="'.$table.'";'."\n\n";

			//run
		$txt.="\t/*\n\t* Run the Database Seeder\n\t*/\n\tpublic function run()\n\t{\n\t\t".'$dataTable = array();'."\n\t\t//\n\t\t".'$dataTable[] = array(/* Data Fields */);'."\n\t\t//\n\t\t".'return Schema::table($this->table)->insert($dataTable);'."\n\t}\n}";

		return $txt;
	}

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$seeds = glob(Application::$root."database/seeds*.php");
		//
		return $seeds;
	}
}