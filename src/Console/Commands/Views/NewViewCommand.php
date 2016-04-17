<?php 

namespace Pikia\Kernel\Console\Command\Views;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pikia\Kernel\Console\Console;
use Pikia\Kernel\Process\View;
use Pikia\Kernel\Config\Config;



class NewViewCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName(Config::get('console.new_view'))
            ->setDescription('New View')
            ->addArgument( 'name', InputArgument::REQUIRED, 'what\'s the name of the view?')
            ->addOption(
               'smarty',
               null,
               InputOption::VALUE_NONE,
               'If set, the view will be in Smarty'
            );
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $isSmarty = $input->getOption('smarty');
        //
        $process = View::create($name , $isSmarty);
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
        if($process == 1) return Console::setMessage("The view is created" , Console::ok );
        else if($process == 2) return Console::setMessage("The view is already existe" , Console::err );
            //"Le fichier deja existe"
        else if($process == 3) return Console::setMessage("The view is already existe" , Console::err );
            //Echec lors de la création des répertoires...
    }
}
