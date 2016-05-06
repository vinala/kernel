<?php 

namespace Pikia\Kernel\Console\Commands;


use Pikia\Kernel\Config\Config;
use Pikia\Kernel\Console\Command\Commands;
use Pikia\Kernel\Process\Seeds;



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
     * Configure the command
     */ 
    public function set()
    {

        $this->key = Config::get('console.new_seed').' {name : what\'s the name of the seed?} {tableName : what\'s the name of the datatable ?}';
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

        //
        $process = Seeds::add($name,$tableName);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The seeder is created");
        else $this->error("The seeder is already existe");
    }
}
