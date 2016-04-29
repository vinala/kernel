<?php 

namespace Pikia\Kernel\Process;

use Pikia\Kernel\Process\Process;

/**
* Controller class
*/
class Command
{
	public static function create($file,$command)
	{
		$Root = Process::root;
		//
		if(!file_exists($Root."app/console/commands/$file.php")){
			$myfile = fopen($Root."app/console/commands/$file.php", "w");
			$txt = self::set($file, $command);
			fwrite($myfile, $txt);
			fclose($myfile);
			//
			return true;
		}
		else return false;

	}

	public static function set($file, $command)
	{
		$txt = "<?php\n\nnamespace Pikia\App\Console\Commands;\n\n";
		$txt .= "use Pikia\Kernel\Console\Command\Commands;\n\n";
		$txt.="\n\nclass $file extends Commands\n{\n\t";

		$txt.="\n\t/**\n\t * The key of the console command.\n\t *\n\t * @var string\n\t */\n\tprotected ".'$key = '."'$command';\n\n";
		$txt.="\n\t/**\n\t * The console command description.\n\t *\n\t * @var string\n\t */\n\tprotected ".'$description = '."'say hello to the world';\n\n";
		$txt.="\n\t/**\n\t * Execute the console command.\n\t *\n\t * @return mixed\n\t */\n\tpublic function handle()\n\t{\n\t\t ".'$this->write("What\'s up!"); '."\n\t}";
		$txt.="\n}";
		return $txt;
	}
}