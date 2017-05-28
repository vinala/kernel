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
    protected $key = 'info {--start}';

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
        $start = $this->option('start');

        $this->show($start);
    }

    /**
     * Format the message to show.
     */
    public function show($start)
    {
        if (!$start) {
            if (!empty(config('app.project'))) {
                $this->line(config('app.project'));
            }
            if (!empty(config('app.owner'))) {
                $this->line('by '.config('app.owner'));
            }
            $this->line('');
            $this->line('***********');
            $this->line('Based on : ');
        } else {
            $this->line('');
        }

        $version = Application::getVersion()->console();
        $this->question('Vinala ', true);
        $this->line("Framework v$version");
        $this->line('-------');
        $this->line(Application::getVersion()->kernel());
        $this->line('-------');
        $this->write('created by Youssef Had (');
        $this->question('youssefhad2@gmail.com - www.facebook.com/yussef.had', true);
        $this->line(')');
        $this->write('Website ');
        $this->question('www.github.com/vinala/vinala');
        $this->line('');
    }
}
