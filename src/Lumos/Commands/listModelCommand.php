<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\Model;

class listModelCommand extends Commands
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
     * Configure the command.
     */
    public function set()
    {
        $this->key = 'list:model';
        //
        $this->description = 'List all models';
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
        $schema = true;
        //
        $data = $this->splite(Model::ListAll());
        //
        $this->show($data);
    }

    /**
     * Format the message to show.
     */
    public function show($array)
    {
        $this->table(['files'], $array);
    }

    /**
     * traite data array.
     */
    public function splite($array)
    {
        $data = [];
        //
        foreach ($array as $key => $value) {
            $data[] = [$value];
        }
        //
        return $data;
    }
}
