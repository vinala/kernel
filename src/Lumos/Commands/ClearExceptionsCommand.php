<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Exception;
use Vinala\Kernel\Database\Database;



class ClearExceptionsCommand extends Commands
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
        $this->key = Config::get('lumos.clear_exception');
        $this->description = 'Clear all exceptions created';
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        // Controller::clear();
        $this->exec();
    }

    /**
     * Execute the command
     */
    public function exec()
    {
        $this->title();
        $ok = $this->confirm("\nAre you sure ? [y/n]" , false);
        //
        if($ok)
        {
            $process = Exception::clear();
            //
            $this->show($process);
        }
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        $this->title('Clear exceptions command :' , '');
        //
        if($process) 
        {
            $this->info("\nThe exceptions folder was emptied\n");
        }
        else $this->error("\nThe exceptions folder won't be emptied\n");
    }
}
