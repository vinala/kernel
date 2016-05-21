<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Foundation\Application;



class InfoCommand extends Commands
{

    /**
     * The key of the console command.
     *
     * @var string
     */
    protected $key = "info";

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = 'Get info about the framework';

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
        $this->line(Application::consoleVersion());
        $this->line(Application::kernelVersion());
        $this->line("created by Youssef Had (youssefhad2@gmail.com - www.facebook.com/yussef.had )");
    }
}
