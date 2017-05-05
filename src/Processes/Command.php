<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Foundation\Application;

/**
 * Controller class.
 */
class Command extends Process
{
    public static function create($file, $command, $database)
    {
        $Root = self::root;

        $path = $Root."support/shell/$file.php";

        if (!File::exists($path)) {
            File::put($path, self::set($file, $command, $database));

            return true;
        } else {
            return false;
        }
    }

    /**
     * prepare the text to put in command file.
     */
    public static function set($file, $command, $database)
    {
        $database = $database ? 'true' : 'false';
        //
        $txt = "<?php\n\nnamespace Vinala\App\Support\Lumos;\n\n";
        $txt .= "use Vinala\Kernel\Console\Command\Commands;\n\n";

        $txt .= self::docs("$file Command");

        $txt .= " class $file extends Commands\n{\n\t";

        $txt .= "\n\t/**\n\t * The key of the console command.\n\t *\n\t * @var string\n\t */\n\tprotected ".'$key = '."'$command';\n\n";
        $txt .= "\n\t/**\n\t * The console command description.\n\t *\n\t * @var string\n\t */\n\tprotected ".'$description = '."'say hello to the world';\n\n";
        $txt .= "\n\t/**\n\t * True if the command will use database.\n\t *\n\t * @var bool\n\t */\n\tprotected ".'$database = '."$database ;\n\n";
        $txt .= "\n\t/**\n\t * Execute the console command.\n\t *\n\t * @return mixed\n\t */\n\tpublic function handle()\n\t{\n\t\t ".'$this->line("What\'s up!"); '."\n\t}";
        $txt .= "\n}";

        return $txt;
    }

    /**
     *   Listing all schemas.
     */
    public static function ListAll()
    {
        $commands = glob(Application::$root.'support/lumos/*.php');
        //
        return $commands;
    }
}
