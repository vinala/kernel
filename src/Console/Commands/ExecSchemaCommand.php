<?php 

namespace Pikia\Kernel\Console\Commands;


use Pikia\Kernel\Config\Config;
use Pikia\Kernel\Console\Command\Commands;
use Pikia\Kernel\Process\Migrations;
use Pikia\Kernel\Database\Database;



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
     * Configure the command
     */ 
    public function set()
    {
        $this->key = Config::get('console.exec_schema');
        $this->description = 'Execute the last schema created';
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
        $process = Migrations::exec();
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The schema is executed");
        else $this->error("Schema is not executed : ".Database::execErr());
    }
}
