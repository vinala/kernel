<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Foundation\Application;



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
        $this->show();
    }

    /**
     * Format the message to show
    */
    public function show()
    {
        $this->line("");
        $this->line("Welcome to Vinala Framework");
        $this->line("by Youssef Had (www.facebook.com/yussef.had)");
        $this->line("");
        $name = $this->question("what's your name ?");
        $this->line("Hello ".$name);

    }
}

