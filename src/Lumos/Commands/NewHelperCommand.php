<?php 

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Helper;



class NewHelperCommand extends Commands
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
        $this->key = config('lumos.new_helper').' {name : what\'s the name of the helper ?}';
        $this->description = 'New Helper';
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
        //
        $process = Helper::create($name);

        $this->show($process , $name);
    }

    /**
     * Format the message to show
    */
    public function show($process , $name)
    {
        $this->title('New helper command :');
        //
        if(! is_null($process) )
        {
            $this->info("\nThe helper was created");
            $this->comment(" -> Path : support/helpers/$name.php\n");
        }
        else $this->error("\nThe helper is already existe\n");
    }
}
