<?php 

namespace Pikia\Kernel\Console\Commands;


use Pikia\Kernel\Config\Config;
use Pikia\Kernel\Console\Command\Commands;
use Pikia\Kernel\Process\Translator;



class NewLanguageFileCommand extends Commands
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
        $this->key = Config::get('console.file_lang')." {fileName : what's the name of the file?} {dirName : what's the name of the directory?}";
        $this->description = "which directory?";
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
        $fileName = $this->argument("fileName");
        $dirName = $this->argument("dirName");
        //
        $process = Translator::createFile($dirName,$fileName);
        //
        $this->show($process);
    }

    /**
     * Format the message to show
    */
    public function show($process)
    {
        if($process) $this->info("The translator file is created");
        else $this->error("The translator file is already existe");
    }
}
