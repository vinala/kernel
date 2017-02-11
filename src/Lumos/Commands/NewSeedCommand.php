<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Seeds;



class NewSeedCommand extends Commands
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

        $this->key = Config::get('lumos.new_seed').' {name : what\'s the name of the seed?} {tableName : what\'s the name of the datatable ?} {count? : who much of rows ?}';
        $this->description = 'New Seeder';

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

        $name = $this->argument('name');
        $tableName = $this->argument('tableName');
        $count = $this->argument('count');
        $count = is_null($count) ? 10 : $count ;

        //
        $process = Seeds::add($name,$tableName,$count);
        //
        $this->show($process, $name);
    }

    /**
     * Format the message to show
    */
    public function show($process, $name)
    {
        if($process) $this->info("$name created");
        else $this->error("The seeder is already existe");
    }
}
