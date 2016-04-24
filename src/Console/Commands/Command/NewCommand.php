<?php 

namespace Pikia\Kernel\Console\Command\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pikia\Kernel\Console\Console;
use Pikia\Kernel\Process\Command as cmd;
use Pikia\Kernel\Config\Config;



class NewCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName(Config::get('console.new_command'))
            ->setDescription('New User Console Cammand')
            ->addArgument( 'file', InputArgument::REQUIRED, 'what\'s the name of the file?')
            ->addOption( 'command', null, InputOption::VALUE_OPTIONAL, 'the command', "greeting" );
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        $command = $input->getOption('command');
        //
        $process = cmd::create($file , $command);
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
        if($process) return Console::setMessage("The command is created" , Console::ok );
        //
        else return Console::setMessage("The command is already existe" , Console::err );
    }
}
