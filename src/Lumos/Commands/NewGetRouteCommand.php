<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Router;

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
     * Configure the command.
     */
    public function set()
    {
        $this->key = config('lumos.commands.get_route').' {http : what\'s the http of route?}';
        $this->description = 'Add new get route to Routes file';
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
        //
        $process = Router::get($http);
        //
        $this->show($process);
    }

    /**
     * Format the message to show.
     */
    public function show($process)
    {
        $this->title('New get route command :');
        //
        if (!is_null($process)) {
            $this->info("\nThe route was created");
            $this->comment(" -> Path : app/http/Routes.php\n");
        } else {
            $this->error("\nThe route doesn't created\n");
        }
    }
}
