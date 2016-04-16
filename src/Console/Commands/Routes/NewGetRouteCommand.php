<?php 

namespace Pikia\Kernel\Console\Command\Routes;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pikia\Kernel\Console\Console;
use Pikia\Kernel\Process\Router;

class NewGetRouteCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('route:get')
            ->setDescription('Add new get route to Routes file')
            ->addArgument( 'http', InputArgument::REQUIRED, 'what\'s the http of route?');
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $http = $input->getArgument('http');
        //
        $process = Router::get($http);
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
        if($process) return Console::setMessage("The route is create" , Console::ok );
        //
        else return Console::setMessage("the route doesn't created" , Console::err );
    }
}
