<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Router;

class NewTargetRouteCommand extends Commands
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
     * Configure the command.
     */
    public function set()
    {
        $this->key = config('lumos.commands.target_route').' {http : what\'s the http of route?} {controller : what\'s the controller you wanna to use?} {method : what\'s the method you wanna to use?}';
        $this->description = 'Add new target route to Routes file';
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->exec();
    }

    /**
     * Execute the command.
     */
    public function exec()
    {
        $http = $this->argument('http');
        $controller = $this->argument('controller');
        $method = $this->argument('method');
        //
        $process = Router::target($http, $controller, $method);
        //
        $this->show($process);
    }

    /**
     * Format the message to show.
     */
    public function show($process)
    {
        $this->title('New traget route command :');
        //
        if ($process) {
            $this->info("\nThe route was created");
            $this->comment(" -> Path : app/http/Routes.php\n");
        } else {
            $this->error("\nThe route doesn't created\n");
        }
    }
}
