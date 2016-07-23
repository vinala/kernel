<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Process\Model;


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
     * Configure the command
     */ 
    public function set()
    {
        $this->key = Config::get('lumos.new_model').' {fileName : what\'s the name of the file?} {className : what\'s the name of the model class?} {tableName : what\'s the name of the datatable?}';
        $this->description = 'New model';
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
        $fileName = $this->argument('fileName');
        $className = $this->argument('className');
        $tableName = $this->argument('tableName');
        //
        $process = Model::create($fileName , $className , $tableName);
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
