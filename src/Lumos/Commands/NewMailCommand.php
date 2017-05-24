<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Mail;

class NewMailCommand extends Commands
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
        // config('lumos.commands.new_link').
        $this->key = 'make:mail {name : what\'s the name of the mailable class?}';
        $this->description = 'New mailable class';
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
        $name = $this->argument('name');
        $process = Mail::create($name);
        //
        $this->show($process, $name);
    }

    /**
     * Format the message to show.
     */
    public function show($process, $file)
    {
        $this->title('New mailable command :');
        //
        if (!is_null($process)) {
            $this->info("\nThe mailable class was created");
            $this->comment(" -> Path : app/mails/$file.php\n");
        } else {
            $this->error("\nThe mailable class is already existe\n");
        }
    }
}
