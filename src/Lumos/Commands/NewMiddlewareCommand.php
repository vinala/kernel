<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\middleware;

class NewMiddlewareCommand extends Commands
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
        $this->key = config('lumos.commands.new_middleware').
        ' {name : what\'s the middleware name ?}';

        $this->description = 'Create new middleware';
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $name = ucfirst($this->argument('name'));

        $process = Middleware::create($name);

        $this->show($process, $name);
    }

    /**
     * Format the message to show.
     */
    public function show($process, $name)
    {
        $this->title('New middleware command :');
        //
        if ($process) {
            $this->info("\nThe middleware was created");
            $this->comment(" -> Path : app/http/middleware/$name.php\n");
        } else {
            $this->error("\nThe middleware is already existe\n");
        }
    }
}
