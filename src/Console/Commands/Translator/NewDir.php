<?php 

namespace Fiesta\Kernel\Console\Command\Translator;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Process\Translator as TR;

class NewDir extends Command
{
    protected function configure()
    {
        $this
            ->setName('lang:new:dir')
            ->setDescription('make new translator directory')
            ->addArgument('name', InputArgument::REQUIRED , 'what\'s the name of the directory?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        //
        $result = TR::createDir($name);
        //
        if($result) $ret = Console::setMessage("The translator directory is created" , Console::ok );
        else $ret = Console::setMessage("The translator directory is already existe" , Console::err );
        //
        $output->writeln($ret);
        
    }
}
