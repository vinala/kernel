<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Migrations;
use Vinala\Kernel\Database\Database;



class RollbackSchemaCommand extends Commands
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
     * Configure the command
     */ 
    public function set()
    {
        $this->key = Config::get('lumos.rollback_schema');
        $this->description = 'Rollback the last schema created';
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        $this->exec();
    }

    /**
     * Execute the command
     */
    public function exec()
    {
        $process = Migrations::rollback();
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The schema is restored");
        else $this->error("There is an error ".Database::execErr());
    }
}
