<?php 

namespace Fiesta\Kernel\Console\Command\Seed;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Process\Seeds;



class NewSeedCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('seed:new')
            ->setDescription('New Seeder')
            ->addArgument( 'name', InputArgument::REQUIRED, 'what\'s the name of the seed?')
            ->addArgument( 'tableName', InputArgument::REQUIRED, 'what\'s the name of the datatable?')
            ;
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $tableName = $input->getArgument('tableName');
        // $addRoute = $input->getOption('route');
        //
        $process = Seeds::add($name,$tableName);
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
        if($process) return Console::setMessage("The seeder is created" , Console::ok );
        //
        else return Console::setMessage("The seeder is already existe" , Console::err );
    }
}
