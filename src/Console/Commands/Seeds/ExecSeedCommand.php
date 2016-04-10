<?php 

namespace Fiesta\Kernel\Console\Command\Seed;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Process\Seeds;
use Fiesta\Kernel\Database\Database;



class ExecSeedCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('seed:exec')
            ->setDescription('Execute Seeder');
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = Seeds::exec();
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
        if($process) return Console::setMessage("The seeder is executed" , Console::ok );
        //
        else return Console::setMessage("There is an error".Database::execErr() , Console::err );
    }
}
