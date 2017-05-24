<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Mail;
use Vinala\Kernel\Config\Alias;

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
     *
     * @return void
     */
    public function set()
    {
        $this->key = config('lumos.commands.new_mail').' {name : what\'s the name of the mailable class?}'.
        ' {--alias : if set , the mailable will be aliased}';
        $this->description = 'New mailable class';
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

        $process = Mail::create($name);
        //
        if ($aliased) {
            Alias::update('mailables.'.$name, 'App\Mails\\'.$name);
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
