<?php 

namespace Fiesta\Kernel\Console\Command\Links;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Process\Links;

class NewLinkFileCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('link:new')
            ->setDescription('New file for links')
            ->addArgument( 'name', InputArgument::REQUIRED, 'what\'s the name of the file?');
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        //
        $process = Links::create($name);
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
        if($process) return Console::setMessage("The link file is created" , Console::ok );
        //
        else return Console::setMessage("The link file is already existe" , Console::err );
    }
}
