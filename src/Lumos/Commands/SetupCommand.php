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
        // $this->show();
        echo "rrrr";
    }

    /**
     * Format the message to show
    */
    public function show()
    {
        $this->line("");
        $this->line(Config::get("app.project"));
        $this->line("by ".Config::get("app.owner"));
        $this->line("***********");
        $this->line("Based on : ");
        $version = Application::consoleVersion();
        $this->question("Lighty ",true);
        $this->line("v$version PHP Framework");
        $this->line(Application::kernelVersion());
        $this->write("created by Youssef Had (");
        $this->question("youssefhad2@gmail.com - www.facebook.com/yussef.had",true);
        $this->line(")");
        $this->write("Website ");
        $this->question("www.gitlab.com/lighty/framework");
        $this->line("");
    }
}

