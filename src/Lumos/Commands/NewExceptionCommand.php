<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Exception;
// use Vinala\Kernel\Logging\Exception;


class NewExceptionCommand extends Commands
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
        $this->key = config('lumos.new_exception').
        ' {name : what\'s the name of the exception ?}'.
        ' {--message : what\'s the message to show if debug was on ?}'.
        ' {--view= : what\'s the view to show if debug was off ?}';

        $this->description = 'Create new exception';
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        $name = $this->argument("name");
        if($this->option("message"))
        {
            $message = $this->ask("what's the message");
        }
        else $message = "";
        $view = $this->option("view");
        //
        $process = Exception::create($name , $message , $view);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("\nThe exception was created\n");
        else $this->error("\nThe exception is already existe\n");
    }
}
