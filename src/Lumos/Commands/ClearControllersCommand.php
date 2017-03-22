<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Controller;
use Vinala\Kernel\Database\Database;



class ClearControllersCommand extends Commands
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
        $this->key = config('lumos.commands.clear_controller');
        $this->description = 'Clear all controllers created';
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
            $process = Controller::clear();
            //
            $this->show($process);
        }
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        $this->title('Clear controllers command :' , '');
        //
        if($process) 
        {
            $this->info("\nThe controllers folder was emptied\n");
        }
        else $this->error("\nThe controllers folder won't be emptied\n");
    }
}
