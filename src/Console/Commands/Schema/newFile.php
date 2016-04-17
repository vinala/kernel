<?php 

namespace Pikia\Kernel\Console\Command\Schema;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pikia\Kernel\Console\Console;
use Pikia\Kernel\Process\Migrations;
use Pikia\Kernel\Config\Config;

class NewSchemaCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName(Config::get('console.new_schema'))
            ->setDescription('make new schema file')
            ->addArgument( 'name', InputArgument::REQUIRED, 'what\'s the name of the schema?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        //
        $process = Migrations::add($name);
        //
        $msg = self::message($process);
        //
        $output->writeln($msg);
    }

    protected static function message($process)
    {
        if($process) return Console::setMessage("The schema is created" , Console::ok );
        //
        else return Console::setMessage("The schema is already existe" , Console::err );
    }
}
