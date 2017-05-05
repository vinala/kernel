<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Foundation\Application;

class InfoCommand extends Commands
{
    /**
     * The key of the console command.
     *
     * @var string
     */
    protected $key = 'info';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = 'Get info about the framework';

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->show();
    }

    /**
     * Format the message to show.
     */
    public function show()
    {
        $this->line('');
        if (!empty(config('app.project'))) {
            $this->line(config('app.project'));
        }
        if (!empty(config('app.owner'))) {
            $this->line('by '.config('app.owner'));
        }
        $this->line("\n\n");
        $this->line('***********');
        $this->line('Based on : ');
        $version = Application::getVersion()->console();
        $this->question('Vinala ', true);
        $this->line("v$version PHP Framework");
        $this->line("\n");
        $this->line(Application::getVersion()->kernel());
        $this->line("\n");
        $this->write('created by Youssef Had (');
        $this->question('youssefhad2@gmail.com - www.facebook.com/yussef.had', true);
        $this->line(')');
        $this->write('Website ');
        $this->question('www.github.com/vinala/vinala');
        $this->line('');
    }
}
