<?php 

namespace Pikia\Kernel\Console\Command\Translator;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pikia\Kernel\Console\Console;
use Pikia\Kernel\Process\Translator as TR;

class NewLanguageDirectoryCommand extends Command
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
        $process = TR::createDir($name);
        //
        $msg = self::message($process);
        //
        $output->writeln($msg);
        
    }

    protected static function message($process)
    {
        if($process) return Console::setMessage("The translator directory is created" , Console::ok );
        //
        else return Console::setMessage("The translator directory is already existe" , Console::err );
    }
}
