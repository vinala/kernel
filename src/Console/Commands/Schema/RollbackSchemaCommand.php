<?php 

namespace Fiesta\Kernel\Console\Command\Schema;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Process\Migrations;
use Fiesta\Kernel\Database\Database;

class RollbackSchemaCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('schema:rollback')
            ->setDescription('Rollback the last schema created');
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = Migrations::rollback();
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
        if($process) return Console::setMessage("The schema is restored" , Console::ok );
        //
        else return Console::setMessage("there is an error ".Database::execErr() , Console::err );
    }
}
