<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Process\Tag;



class NewTagCommand extends Commands
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
        $this->key = Config::get('lumos.new_tag').' {class : what\'s the name of the tag class ?} {tag? : what\'s the name of the tag ?} {target? : what\'s the name of the function ?} {--write : if set Atomium will write the returned value from function}';
        $this->description = "New User Atomium Tag";
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
        $class = $this->argument("class");
        $target = $this->argument("target");
        $tag = $this->argument("tag");
        $write = $this->option("write");
        //
        $process = Tag::create($class, $target, $tag, $write);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The command is created");
        else $this->error("The command is already existe");
    }
}
