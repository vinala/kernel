<?php 

namespace Pikia\Kernel\Console\Commands;


use Pikia\Kernel\Config\Config;
use Pikia\Kernel\Console\Command\Commands;
use Pikia\Kernel\Process\Controller;



class NewControllerCommand extends Commands
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
        $this->key = Config::get('console.new_controller').' {fileName : what\'s the name of the file?} {className : what\'s the name of the controller class?} {--route : If set, a router for this controller will created in routes file}';
        $this->description = 'New Controller';
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
        $fileName = $this->argument("fileName");
        $className = $this->argument("className");
        $addRoute = $this->option("route");
        //
        $process = Controller::create($fileName , $className , $addRoute);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The controller is created");
        else $this->error("The controller is already existe");
    }
}
