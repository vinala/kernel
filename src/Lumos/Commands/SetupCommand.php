<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Setup\Response;

class SetupCommand extends Commands
{
    /**
     * The key of the console command.
     *
     * @var string
     */
    protected $key = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = '';

    /**
     * Handle the command.
     */
    public function handle()
    {
        $key1 = md5(uniqid(rand(), true));
        $key2 = md5(uniqid(rand(), true));
        Response::setSecur_step($key1, $key2);
        $this->line("\nThe generated framework keys : ");
        //
        $this->write('first key : ');
        $this->info("$key1");
        $this->write('second key : ');
        $this->info("$key2");
    }
}
