<?php 

namespace Fiesta\Kernel\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;
use Fiesta\Kernel\Foundation\Application;

class Info extends Command
{
    protected function configure()
    {
        $this
            ->setName('info')
            ->setDescription('Get info about the framework')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$output->writeln(self::info());
    }

    protected function info()
    {
        $print = "";
        $print .= Console::setMessage(Application::consoleVersion()."\n", Console::rmq );
        $print .= Console::setMessage(Application::kernelVersion()."\n", Console::rmq );
        $print .= Console::setMessage("created by Youssef Had (youssefhad2@gmail.com - www.facebook.com/yussef.had )", Console::rmq );
        //
        return $print;
    }
}
