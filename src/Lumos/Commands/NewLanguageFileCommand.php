<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Translator;

class NewLanguageFileCommand extends Commands
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
        $this->key = config('lumos.commands.new_lang')." {file : what's the name of the file?} ";
        $this->description = 'Make new translator file';
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
        $file = $this->argument('file');
        //
        $process = Translator::create($file);
        //
        $file = str_replace('.', '/', $file);
        //
        $this->show($process, $file);
    }

    /**
     * Format the message to show.
     */
    public function show($process, $name)
    {
        $this->title('New translator command :');
        //
        if (!is_null($process)) {
            $this->info("\nThe translator file was created");
            $this->comment(" -> Path : resources/translator/$name.php\n");
        } else {
            $this->error("\nThe translator file is already existe\n");
        }
    }
}
