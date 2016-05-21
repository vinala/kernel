<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Process\Translator;



class listLangCommand extends Commands
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
        $this->key = "list:lang";
        //
        $this->description = 'List all folders and files language';
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
