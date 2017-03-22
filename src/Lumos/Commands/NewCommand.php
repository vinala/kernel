<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Command;



class NewCommand extends Commands
{

    /**
     * The key of the console command.
     *
     * @var string
     */
    protected $key;

    /**
     * The console command description.
     *
     * @var string
     */
    public $description;

    /**
     * Configure the command
     */ 
    public function set()
    {
        $this->key = config('lumos.commands.new_command').' {file : what\'s the name of the file?} {--database : if is set the command will use the database} {--command=greeting : the command}';
        $this->description = "New User Console Cammand";
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        $this->exec();
    }

    /**
     * Execute the command
     */
    public function exec()
    {
        $file = $this->argument("file");
        $command = $this->option("command");
        $database = $this->option("database");
        //
        $process = Command::create($file , $command , $database);
        //
        $this->show($process , $file);
    }

    /**
     * Format the message to show
    */
    public function show($process , $name)
    {
        $this->title('New command :');
        //
        if($process) 
        {
            $this->info("\nThe command was created");
            $this->comment(" -> Path : support/shell/$name.php\n");
        }
        else $this->error("\nThe command is already existe\n");
    }
}
