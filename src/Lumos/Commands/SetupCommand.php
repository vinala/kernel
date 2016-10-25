<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Setup\Response;



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
        Response::setGlob_step($project , $name , $lang , $debugging , $hide);
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

