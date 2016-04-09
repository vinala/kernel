<?php 

namespace Fiesta\Kernel\Console\Command\Models;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Process\Model;

class NewModelCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('model:new')
            ->setDescription('New model')
            ->addArgument( 'fileName', InputArgument::REQUIRED, 'what\'s the name of the file?')
            ->addArgument( 'classnNme', InputArgument::REQUIRED, 'what\'s the name of the class?')
            ->addArgument( 'tableName', InputArgument::REQUIRED, 'what\'s the name of the datatable?');
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('fileName');
        $className = $input->getArgument('classnNme');
        $tableName = $input->getArgument('tableName');
        //
        $process = Model::create($fileName , $className , $tableName);
        //
        $msg = self::message($process);
        //
        $output->writeln($msg);
    }


    /**
     * Format the message to show
    */
    protected static function message($process)
    {
        if($process) return Console::setMessage("The model is created" , Console::ok );
        //
        else return Console::setMessage("The model is already existe" , Console::err );
    }
}
