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
        $this->key = Config::get('lumos.clear_controller');
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
        $ok = $this->confirm("Are you sure ? [y/n]" , false);
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
        if($process) $this->info("The controllers folder was emptied");
        else $this->error("The controllers folder won't be emptied : ".Database::execErr());
    }
}
