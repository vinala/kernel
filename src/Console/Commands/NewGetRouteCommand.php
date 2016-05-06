<?php 

namespace Pikia\Kernel\Console\Commands;


use Pikia\Kernel\Config\Config;
use Pikia\Kernel\Console\Command\Commands;
use Pikia\Kernel\Process\Router;


class NewGetRouteCommand extends Commands
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
        $this->key = Config::get('console.get_routes').' {http : what\'s the http of route?}';
        $this->description = 'Add new get route to Routes file';
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
        //
        $process = Router::get($http);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The route is create");
        else $this->error("The route doesn't created");
    }
}
