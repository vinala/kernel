<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Links;



class listLinksCommand extends Commands
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
        $this->key = "list:link";
        //
        $this->description = 'List all links';
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
        $data = $this->splite(Links::ListAll());
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
