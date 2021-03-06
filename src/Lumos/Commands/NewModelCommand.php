<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Alias;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Model;

class NewModelCommand extends Commands
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
     * True if the command will use database.
     *
     * @var bool
     */
    protected $database = false;

    /**
     * Configure the command.
     */
    public function set()
    {
        $this->key = config('lumos.commands.new_model').
        ' {className : what\'s the name of the model class?} {tableName? : what\'s the name of the datatable?} {--not_aliased : if set , the model will be not aliased}';
        $this->description = 'New model';
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->exec();
    }

    /**
     * Execute the command.
     */
    public function exec()
    {
        $class = $this->argument('className');
        $table = $this->argument('tableName');
        //
        if (is_null($table)) {
            $table = $class;
        }
        //
        $notAliased = $this->option('not_aliased');
        //
        $process = Model::create($class, $table, $notAliased);

        if (!$notAliased) {
            $class = ucfirst($class);
            //
            Alias::update('models.'.$class, 'App\Model\\'.$class);
        }
        //
        $this->show($process, $class);
    }

    /**
     * Format the message to show.
     */
    public function show($process, $name)
    {
        $this->title('New model command :');
        //
        if ($process) {
            $this->info("\nThe model was created");
            $this->comment(" -> Path : resources/models/$name.php\n");
        } else {
            $this->error("\nThe model is already existe\n");
        }
    }
}
