<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Translator;
use Vinala\Kernel\Foundation\Component;



class listComponentCommand extends Commands
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
        $this->key = "list:component";
        //
        $this->description = 'List all folders and files language';
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        $compnentParams = Component::load();
        //
        foreach ($compnentParams as $key => $value) {
            $this->write($key);
            $this->write(".....");
            if($value)$this->info("Enabled");
            else $this->error("Disabled");
        }
    }

    /**
     * Execute the command
     */
    public function exec()
    {
        $schema = true;
        //
        $data = $this->splite(Translator::ListAll());
        //
        $this->show($data);
    }

    /**
     * Format the message to show
    */
    public function show($array)
    {
        $this->table(["files"] , $array);
    }

    /**
     * traite data array
    */
    public function splite($array)
    {
        $data = array();
        //
        foreach ($array as $key => $value) {
            $data[] = array($value);
        }
        //
        return $data;
    }
}
