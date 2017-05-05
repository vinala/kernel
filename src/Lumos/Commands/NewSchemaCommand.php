<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Migrations;

class NewSchemaCommand extends Commands
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
     * True if the command will use database.
     *
     * @var bool
     */
    protected $database = true;

    /**
     * Configure the command.
     */
    public function set()
    {
        $this->key = config('lumos.commands.new_schema').' {name : what\'s the name of the schema?}';
        $this->description = 'Make new schema file';
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
        //
        $process = Migrations::add($name);
        //
        $this->show($process, $name);
    }

    /**
     * Format the message to show.
     */
    public function show($process, $name)
    {
        $this->title('New schema command :');
        //
        if (!is_null($process)) {
            $this->info("\nThe schema was created");
            $this->comment(" -> Path : database/schema/$process"."_$name.php\n");
        } else {
            $this->error("\nThe schema is already existe\n");
        }
    }
}
