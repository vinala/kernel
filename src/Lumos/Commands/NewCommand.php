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
        $this->key = Config::get('lumos.new_command').' {file : what\'s the name of the file?} {--command=greeting : the command}';
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
        //
        $process = Command::create($file , $command);
        //
        $this->show($process , $file);
    }

    /**
     * Format the message to show
    */
    public function show($process , $name)
    {
        if($process) $this->info("The command was created");
        else $this->error("The command is already existe");

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
