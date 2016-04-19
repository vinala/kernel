<?php 

namespace Pikia\Kernel\Console\Command\Various;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pikia\Kernel\Console\Console;
use Pikia\Kernel\Config\Config;
use Pikia\Kernel\Objects\Strings;



class AllCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('all')
            ->setDescription('All Pikia commands');
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = $this->all();
        //
        $output->writeln($msg);
    }


    /**
     * Complete with specific char
     */
    protected function completeCom($key , $max)
    {
        $char = ".";        
        //
        $command = $this->cmnds();
        $command = $command[$key];
        $lenght = Strings::lenght($command);
        //
        $differnce = $max - $lenght;
        //
        $result = $command;
        //
        for ($i=0; $i <= $differnce+3 ; $i++) 
            $result .= $char;
        //
        return $result;
    }

    protected function completeDoc($key , $max)
    {
        $char = ".";        
        //
        $docs = $this->docs($key);
        $docs = $docs[$key];
        $lenght = Strings::lenght($docs);
        //
        $differnce = $max - $lenght;
        //
        $result = $docs;
        //
        for ($i=0; $i <= $differnce+3 ; $i++) 
            $result .= $char;
        //
        return $result;
    }

    /**
     * Get the lenght of the longest command
     */
    protected function cmnMaxSize()
    {
        $cmd = self::cmnds();
        //
        $max = 0;
        // die(var_dump($cmd));
        //
        foreach ($cmd as $key => $value) 
        {
            if(is_array($value)) die('ttt');
            if(Strings::lenght($value) > $max) $max = Strings::lenght($value);
        }
        //
        return $max;
    }

    /**
     * Get the lenght of the longest command
     */
    protected function docMaxSize()
    {
        $doc = self::docs();
        //
        $max = 0;
        // die(var_dump($doc));
        //
        foreach ($doc as $key => $value) 
        {
            if(is_array($value)) die('ttts');
            if(Strings::lenght($value) > $max) $max = Strings::lenght($value);
        }
        //
        return $max;
    }



    /**
     * All Documentation  of commands
     */
    protected function docs()
    {
        return array(
            'info' => "Get info about the framework", 
            'all' => "All Pikia commands", 
            'new_schema' => "Make new schema file", 
            'exec_schema' => "Execute the last schema created", 
            'rollback_schema' => "Rollback the last schema created", 
            'dir_lang' => "Make new translator directory", 
            'file_lang' => "Make new translator file", 
            'new_link' => "New file for links", 
            'new_model' => "New Model", 
            'new_view' => "New View", 
            'new_controller' => "New Controller", 
            'new_seed' => "New Seeder", 
            'exec_seed' => "Execute Seeder", 
            'get_routes' => "Add new get route to Routes file", 
            );
    }

    /**
     * All commands
     */
    protected function cmnds()
    {
        return array(
            'info' => "info", 
            'all' => "all", 
            'new_schema' => Config::get('console.new_schema'), 
            'exec_schema' => Config::get('console.exec_schema'), 
            'rollback_schema' => Config::get('console.rollback_schema'), 
            'dir_lang' => Config::get('console.dir_lang'), 
            'file_lang' => Config::get('console.file_lang'), 
            'new_link' => Config::get('console.new_link'), 
            'file_lang' => Config::get('console.file_lang'), 
            'new_link' => Config::get('console.new_link'), 
            'new_model' => Config::get('console.new_model'), 
            'new_view' => Config::get('console.new_view'), 
            'new_controller' => Config::get('console.new_controller'), 
            'new_seed' => Config::get('console.new_seed'), 
            'exec_seed' => Config::get('console.exec_seed'), 
            'get_routes' => Config::get('console.get_routes'), 
            );
    }


    protected function title($title)
    {
        return Console::setMessage("$title\n" , Console::lst );
    }

    protected function showParams($params)
    {
        return Console::setCyan("$params");
    }

    protected function row($key , $maxCommand , $maxDoc , $params = "")
    {
        $command = $this->completeCom($key , $maxCommand);
        $doc = $this->completeDoc($key , $maxDoc);
        //
        return Console::setMessage(" ".$command.$doc.($params != "" ? "|  ".$this->showParams($params) : "")."\n" , Console::nn);
    }

    protected function all()
    {
        $maxCommand = $this->cmnMaxSize();
        $maxDocs = $this->docMaxSize();
        //
        $process = "\n";
        //
        $process .= $this->row("info" , $maxCommand , $maxDocs );
        $process .= $this->row("all" , $maxCommand , $maxDocs );
        //
        $process .= $this->title("schema");
        $process .= $this->row("new_schema" , $maxCommand , $maxDocs , "<name>");
        $process .= $this->row("exec_schema" , $maxCommand , $maxDocs );
        $process .= $this->row("rollback_schema" , $maxCommand , $maxDocs );
        //
        $process .= $this->title("lang");
        $process .= $this->row("dir_lang" , $maxCommand , $maxDocs , "<name>");
        $process .= $this->row("file_lang" , $maxCommand , $maxDocs , "<fileName> <dirName>");
        //
        $process .= $this->title("link");
        $process .= $this->row("new_link" , $maxCommand , $maxDocs , "<fileName>");
        //
        $process .= $this->title("model");
        $process .= $this->row("new_model" , $maxCommand , $maxDocs , "<fileName> <className> <tableName>");
        //
        $process .= $this->title("view");
        $process .= $this->row("new_view" , $maxCommand , $maxDocs , "<fileName>  --smarty");
        //
        $process .= $this->title("controller");
        $process .= $this->row("new_controller" , $maxCommand , $maxDocs , "<fileName> <className>  --addRoute");
        //
        $process .= $this->title("seed");
        $process .= $this->row("new_seed" , $maxCommand , $maxDocs , "<name> <tableName>");
        $process .= $this->row("exec_seed" , $maxCommand , $maxDocs);
        //
        $process .= $this->title("routes");
        $process .= $this->row("get_routes" , $maxCommand , $maxDocs , "<http>");
        //
        return $process;
    }
}