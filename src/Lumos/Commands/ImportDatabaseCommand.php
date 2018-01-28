<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Database\Database;

class ImportDatabaseCommand extends Commands
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
        $this->key = config('lumos.commands.import_database', 'import:database').' {file? : what\'s the name of the file to import?}';
        $this->description = 'Import the database backup folder';
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
        $name = $this->argument('file');

        $process = Database::import($name);

        //
        $this->show($process);
    }

    /**
     * Format the message to show.
     */
    public function show($process)
    {
        $this->title('Import database command :');
        //
        if ($process) {
            $this->info("\nThe database imported successfully");
            $this->comment(" -> Path : database/backup\n");
        } else {
            $this->error("\nThe database wasn't imported\n");
        }
    }
}
