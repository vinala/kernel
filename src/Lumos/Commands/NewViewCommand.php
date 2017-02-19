<?php 

namespace Vinala\Kernel\Console\Commands;


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Console\Command\Commands;
use Vinala\Kernel\Process\View;



class NewViewCommand extends Commands
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
        $this->key = Config::get('lumos.new_view')." {name : what's the name of the view?} {--smarty : If set, the view will be in Smarty} {--atom : If set, the view will be in Atomium}";
        $this->description = "New View";
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        $this->exec();
    }

    /**
     * Check template
     */
    public function template()
    {
        if($this->option("smarty")) return "smarty";
        elseif($this->option("atom")) return "atom";
        else return null;
    }

    /**
     * Execute the command
     */
    public function exec()
    {
        $name = $this->argument("name");
        //
        $temp = $this->template();
        //
        $process = View::create($name , $temp);
        //
        $this->show($process , [$name , $temp]);
    }

    /**
     * Format the message to show
    */
    private function show($process , $extra)
    {
        $path = $this->name($extra);

        $this->title('New View command :');
        //
        if($process == 1) 
        {
            $this->info("\nThe view was created");
            $this->comment(" -> Path : resources/views/$path\n");
        }
        else if($process == 2) $this->error("The view is already existe");
        else if($process == 3) $this->error("Failed to create directories ...");
    }

    /**
    * Get the path , name , and type of view
    *
    * @param string $name
    * @return string
    */
    private function name($extra)
    {
        $file = $extra[0];
        $file = str_replace('.', '/', $file);
        //
        switch ($extra[1]) {
            case 'smarty': $extention = ".tpl.php"; break;
            case 'atom': $extention = ".atom"; break;
            default: $extention = ".php"; break;
        }

        return $file.$extention;
    }
    
}
