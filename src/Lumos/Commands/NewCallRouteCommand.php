<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Router;


class NewCallRouteCommand extends Commands
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
        $this->key = config('lumos.call_routes').' {http : what\'s the http of route?} {controller : what\'s the controller you wanna to use?} {method : what\'s the method you wanna to use?}';
        $this->description = 'Add new call route to Routes file';
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
        $http = $this->argument('http');
        $controller = $this->argument('controller');
        $method = $this->argument('method');
        //
        $process = Router::call($http , $controller , $method);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The route was created");
        else $this->error("The route doesn't created");
    }
}
