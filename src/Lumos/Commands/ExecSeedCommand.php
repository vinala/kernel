<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Seeds;
use Vinala\Kernel\Database\Database;



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

    public function onoff($key, $stat)
    {
        if($stat)
        {
            $this->write("$key -> ");
            $this->green("succeed");
        }
        else
        {
            $this->write("$key -> ");
            $this->red("failed");
        }
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        foreach ($process as $key => $value) 
            self::onoff($key, $value);
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
