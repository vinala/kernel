<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Events;

class NewEventListenerCommand extends Commands
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
        $this->key = config('lumos.commands.new_event').
        ' {name : what\'s the name of the events listener ?}';

        $this->description = 'Create new events listener';
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        //
        $process = Events::create($name);
        //
        $this->show($process, $name);
    }

    /**
     * Format the message to show.
     */
    public function show($process, $file)
    {
        $this->title('New event command :');
        //
        if ($process) {
            $this->info("\nThe event listener was created");
            $this->comment(" -> Path : app/events/$file.php\n");
        } else {
            $this->error("\nThe event listener is already existe\n");
        }
    }
}
