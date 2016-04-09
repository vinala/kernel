<?php 

namespace Fiesta\Kernel\Console\Command\Translator;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Process\Translator;

class NewFile extends Command
{
    protected function configure()
    {
        $this
            ->setName('lang:new:file')
            ->setDescription('make new translator file')
            ->addArgument( 'fileName', InputArgument::REQUIRED, 'what\'s the name of the file?')
            ->addArgument( 'dirName', InputArgument::REQUIRED, 'which directory?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('fileName');
        $dirName = $input->getArgument('dirName');
        //
        $result = Translator::createFile($dirName,$fileName);
        //
        if($result) $ret = Console::setMessage("The translator file is created" , Console::ok );
        else $ret = Console::setMessage("The file is already existe" , Console::err );
        //
        $output->writeln($ret);
    }
}
