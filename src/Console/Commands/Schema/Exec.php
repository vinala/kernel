<?php 

namespace Pikia\Kernel\Console\Command\Schema;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pikia\Kernel\Console\Console;
use Pikia\Kernel\Process\Migrations;
use Pikia\Kernel\Database\Database;
use Pikia\Kernel\Config\Config;

class ExecSchemaCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName(Config::get('console.exec_schema'))
            ->setDescription('Execute the last schema created');
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = Migrations::exec();
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
        if($process) return Console::setMessage("The schema is executed" , Console::ok );
        //
        else return Console::setMessage("Schema is not executed : ".Database::execErr() , Console::err );
    }
}
