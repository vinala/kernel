<?php

namespace Vinala\Kernel\Console\Commands;

use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Setup\Documentations\Maintenance;

class SwitchMaintenanceCommand extends Commands
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
        $this->key = config('lumos.commands.switch_maintenance');
        $this->description = 'Enable or disable maintenance mode';
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $maintenance = !config('maintenance.enabled');

        $out = config('maintenance.out');
        $view = config('maintenance.view');
        //
        $script = Maintenance::set($maintenance ? 'true' : 'false', $out, $view);

        $this->show(File::put(root().'config/maintenance.php', $script), $maintenance);

        return true;
    }

    /**
     * Format the message to show.
     */
    public function show($process, $debug)
    {
        if ($process) {
            $this->info("\nThe maintenance mode is ".($debug ? 'enabled' : 'disabled')."\n");
        } else {
            $this->error("\nThe maintenance mode won't be switched\n");
        }
    }
}
