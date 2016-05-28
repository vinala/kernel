<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Process\Seeds;
use Lighty\Kernel\Database\Database;



class ExecSeedCommand extends Commands
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
        $this->key = Config::get('lumos.exec_seed');
        $this->description = 'Execute Seeder';
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
        $process = Seeds::exec();
        //
        $this->show($process);
        $this->backup($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The seeder executed");
        else $this->error("There is an error".Database::execErr());
    }

    /**
     * Make backup for database
     */
    protected function backup($process)
    {
        if($process)
        {
            $this->line("");
            //
            $ok = $this->confirm("Wanna make backup for database ? [yes/no]" , false);
            //
            if($ok) 
                if(Database::export()) $this->info("The database saved");
                else $this->error("The database wasn't saved");
        }
    }
}
