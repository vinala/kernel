<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Process\Migrations;

class ExecSchemaCommand extends Commands
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
        $this->key = config('lumos.commands.exec_schema').' {schema? : what\'s the name of the schema?} ';
        $this->description = 'Execute the last schema created';
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
        $schema = $this->argument('schema');

        $process = Migrations::exec($schema);
        //
        $this->show($process);
        $this->backup($process);
    }

    /**
     * Format the message to show.
     */
    public function show($process)
    {
        if ($process) {
            $this->info('The schema executed');
        } else {
            $this->error('Schema not executed : '.Database::execErr());
        }
    }

    /**
     * Make backup for database.
     */
    protected function backup($process)
    {
        $this->title('Execute schema command :');
        if ($process) {
            $this->line('');
            //
            $ok = $this->confirm("\nWanna make backup for database ? [yes/no]", false);
            //
            if ($ok) {
                if (Database::export()) {
                    $this->info("\nThe database saved\n");
                } else {
                    $this->error("\nThe database wasn't saved\n");
                }
            }
        }
    }
}
