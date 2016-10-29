<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Setup\Response;



class SetupCommand extends Commands
{

    /**
     * The key of the console command.
     *
     * @var string
     */
    protected $key = "setup";

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = '';

    /**
     * Handle the command
     */
    public function handle()
    {
        $this->line("\nWelcome to Vinala Framework");
        $this->line("by Youssef Had (www.facebook.com/yussef.had)");
        //
        $key1 = md5(uniqid(rand(), TRUE));
        $key2 = md5(uniqid(rand(), TRUE));
        Response::setSecur_step($key1 , $key2);
        $this->line("\nThe generated framework keys : ");
        //
        $this->write("first key : ");
        $this->info("$key1");
        $this->write("second key : ");
        $this->info("$key2");
    }
}

