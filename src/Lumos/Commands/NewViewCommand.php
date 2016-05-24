<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Process\View;



class NewViewCommand extends Commands
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
        $this->key = Config::get('lumos.new_view')." {name : what's the name of the view?} {--smarty : If set, the view will be in Smarty}";
        $this->description = "New View";
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
        $name = $this->argument("name");
        $isSmarty = $this->option("smarty");
        //
        $process = View::create($name , $isSmarty);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process == 1) $this->info("The view is created");
        else if($process == 2) $this->error("The view is already existe");
        else if($process == 3) $this->error("Failed to create directories ...");
    }
}
