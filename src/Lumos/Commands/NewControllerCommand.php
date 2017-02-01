<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Config\Alias;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Controller;



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
        $this->key = Config::get('lumos.new_controller').' {name : what\'s the name of the controller ?} {route? : If set, a router for this controller will created in routes file} {--resource : If set, the controller will be created with recources methods} {--not_aliased : if set , the controller will be not aliased}';
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
        $name = $this->argument("name");
        $route = $this->argument("route");
        $resource = $this->option("resource");
        $notAliased = $this->option('not_aliased');
        //
        $process = Controller::create($name , $route , $resource);

        if( ! $notAliased)
        {
            $class = ucfirst($name);
            //
            Alias::update('controllers.'.$class , 'App\Controller\\'.$class );
        }
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("\nThe controller was created\n");
        else $this->error("\nThe controller is already existe\n");
    }
}
