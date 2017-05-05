<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Links;

class NewLinkFileCommand extends Commands
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
        $this->key = config('lumos.commands.new_link').' {name : what\'s the name of the file?}';
        $this->description = 'New file for links';
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
        $process = Links::create($name);
        //
        $this->show($process, $name);
    }

    /**
     * Format the message to show.
     */
    public function show($process, $file)
    {
        $this->title('New linker command :');
        //
        if (!is_null($process)) {
            $this->info("\nThe link file was created");
            $this->comment(" -> Path : resources/links/$file.php\n");
        } else {
            $this->error("\nThe link file is already existe\n");
        }
    }
}
