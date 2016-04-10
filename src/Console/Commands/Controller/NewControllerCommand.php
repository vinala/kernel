<?php 

namespace Fiesta\Kernel\Console\Command\Controller;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Process\Controller;



class NewControllerCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('controller:new')
            ->setDescription('New Controller')
            ->addArgument( 'fileName', InputArgument::REQUIRED, 'what\'s the name of the file?')
            ->addArgument( 'className', InputArgument::REQUIRED, 'what\'s the name of the controller class?')
            ->addOption(
               'route',
               null,
               InputOption::VALUE_NONE,
               'If set, a router for this controller will created in routes file'
            );
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('fileName');
        $className = $input->getArgument('className');
        $addRoute = $input->getOption('route');
        //
        $process = Controller::create($fileName , $className , $addRoute);
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
        if($process) return Console::setMessage("The controller is created" , Console::ok );
        //
        else return Console::setMessage("The controller is already existe" , Console::err );
    }
}
