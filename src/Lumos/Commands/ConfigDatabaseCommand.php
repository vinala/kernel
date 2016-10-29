<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Lumos\Response\ConfigSetting;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Controller;
use Vinala\Kernel\Database\Database;



class ConfigDatabaseCommand extends Commands
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
        $this->key = Config::get('lumos.config_database').' {driver : what\'s the database server ? }';
        $this->description = 'Config database params';
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        // $server = $this->choice("What's your database server ?" , ['sqlite' , 'mysql' , 'pgsql' , 'sqlsrv']);
        $driver = $this->argument("driver");
        //
        switch ($driver) {

            case 'mysql':
                    $this->line();
                    $host = $this->ask("What's your host name ?" , "localhost");
                    $database = $this->ask("What's your database name ?");
                    $user = $this->ask("What's your user name ?");
                    $password = $this->hidden("What's your password ?");
                    $prefix = $this->ask("What's database prefix (if you keep it empty the prefixing will be disabled) ?");
                    if(empty($prefix)) $prefix = null;
                    //
                    if(ConfigSetting::database($driver , $host , $database , $user , $password , $prefix))
                        $this->info("\nThe database configuration complated with seccus\n");
                    else $this->error("\nThere is an error\n");
                break;
            



        }
    }

    /**
     * Execute the command
     */
    public function exec()
    {
        $ok = $this->confirm("Are you sure ? [y/n]" , false);
        //
        if($ok)
        {
            $process = Controller::clear();
            //
            $this->show($process);
        }
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The controllers folder was emptied");
        else $this->error("The controllers folder won't be emptied : ".Database::execErr());
    }
}
