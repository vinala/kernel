<?php 

namespace Fiesta\Kernel\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;

class Info extends Command
{
    protected function configure()
    {
        $this
            ->setName('fiesta:info:owner')
            ->setDescription('Get info about the framework')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = "Youssef Had (youssefhad2@gmail.com - www.facebook.com/yussef.had )";
        //
    	$output->writeln(Console::setMessage($text , Console::rmq ));
                
    }
}
