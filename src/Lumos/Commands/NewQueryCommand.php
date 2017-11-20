<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Alias;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Query;

class NewQueryCommand extends Commands
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
     *
     * @return void
     */
    public function set()
    {
        $this->key = 'make:query {name : what\'s the name of the querying class?}'.
        ' {--alias : if set , the querying will be aliased}';
        $this->description = 'New querying class';
    }

    /**
     * Handle the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->exec();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function exec()
    {
        $name = $this->argument('name');
        $aliased = $this->option('alias');

        $process = Query::create($name);
        //
        if ($aliased) {
            // Alias::update('querying.'.$name, 'App\Queries\\'.$name);
        }
        //
        $this->show($process, $name);
    }

    /**
     * Format the message to show.
     *
     * @return void
     */
    public function show($process, $file)
    {
        $this->title('New querying command :');
        //
        if (!is_null($process)) {
            $this->info("\nThe querying class was created");
            $this->comment(" -> Path : app/queries/$file.php\n");
        } else {
            $this->error("\nThe querying class is already existe\n");
        }
    }
}
