<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Tag;

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
        $this->key = config('lumos.commands.new_tag').' {class : what\'s the name of the tag class ?} {tag : what\'s the name of the tag (without @) ?} {target : what\'s the name of the function ?} {--hold : if set Atomium will just excute the function without write the returned value from function}';
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
        $hold = $this->option("hold");
        //
        $process = Tag::create($class, $target, $tag, $hold);
        //
        $this->show($process, $class);
    }

    /**
     * Format the message to show
    */
    public function show($process, $name)
    {
        $this->title('New Atomium tag command :');
        //
        if ($process) {
            $this->info("\nThe tag was created");
            $this->comment(" -> Path : resources/tags/$name.php\n");
        } else {
            $this->error("\nThe tag is already existe\n");
        }
    }
}
