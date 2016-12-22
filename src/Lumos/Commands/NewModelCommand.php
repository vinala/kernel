<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Config\Alias;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Model;


class NewModelCommand extends Commands
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
    protected $database = false;

    /**
     * Configure the command
     */ 
    public function set()
    {
        $this->key = Config::get('lumos.new_model').' {className : what\'s the name of the model class?} {tableName : what\'s the name of the datatable?}';
        $this->description = 'New model';
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        Alias::update('exceptions.rrrr','rtert');
        // $this->exec();
    }

    /**
     * Execute the command
     */
    public function exec()
    {
        $className = $this->argument('className');
        $tableName = $this->argument('tableName');
        //
        $process = Model::create( $className , $tableName);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The model was created");
        else $this->error("The model is already existe");
    }
}
