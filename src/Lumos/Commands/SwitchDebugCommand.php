<?php 

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Setup\Documentations\Loggin;
use Vinala\Kernel\Console\Command\Commands;

class SwitchDebugCommand extends Commands
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
        $this->key = config('lumos.switch_debug');
        $this->description = 'Enable or disable debug mode';
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        $debug = ! config('loggin.debug');
        
        $log = config('loggin.log');
        //
        $script = Loggin::set($debug , $log);

        $this->show(file_put_contents(root().'config/loggin.php', $script, 0) , $debug);

        return true;
    }


    /**
     * Format the message to show
    */
    public function show($process , $debug)
    {
        if($process) $this->info("\nThe debug mode is " . ($debug ? 'enabled' : 'disabled') ."\n");
        else $this->error("\nThe debug mode won't be switched\n");
    }
}
