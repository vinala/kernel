<?php 

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Tests;



class NewTestCommand extends Commands
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
        $this->key = config('lumos.commands.new_test').' {name : what\'s the name of the test class (without test preffix) ?}';
        $this->description = 'New Test class';
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
        $process = Tests::create($name);

        $this->show($process , $name);
    }

    /**
     * Format the message to show
    */
    public function show($process , $name)
    {
        $this->title('New tests command :');
        //
        if(! is_null($process) )
        {
            $this->info("\nThe test class was created");
            $this->comment(" -> Path : tests/$name.php\n");
        }
        else $this->error("\nThe test class is already existe\n");
    }
}
