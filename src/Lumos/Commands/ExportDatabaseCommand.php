<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Database\Database;

class ExportDatabaseCommand extends Commands
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
        $this->key = config('lumos.commands.export_database');
        $this->description = 'Save database in current time';
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
        $process = Database::export();
        //
        $this->show($process);
    }

    /**
     * Format the message to show.
     */
    public function show($process)
    {
        $this->title('Save database command :');
        //
        if ($process) {
            $this->info("\nThe database saved");
            $this->comment(" -> Path : database/backup\n");
        } else {
            $this->error("\nThe database wasn't saved\n");
        }
    }
}
