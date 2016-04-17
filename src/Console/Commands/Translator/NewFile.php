<?php 

namespace Pikia\Kernel\Console\Command\Translator;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pikia\Kernel\Console\Console;
use Pikia\Kernel\Process\Translator;
use Pikia\Kernel\Config\Config;

class NewLanguageFileCommand extends Command
{
    /**
     * Configure de command
     */
    protected function configure()
    {
        $this
            ->setName(Config::get('console.file_lang'))
            ->setDescription('make new translator file')
            ->addArgument( 'fileName', InputArgument::REQUIRED, 'what\'s the name of the file?')
            ->addArgument( 'dirName', InputArgument::REQUIRED, 'which directory?');
    }

    /**
     * Execute de command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('fileName');
        $dirName = $input->getArgument('dirName');
        //
        $process = Translator::createFile($dirName,$fileName);
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
        if($process) return Console::setMessage("The translator file is created" , Console::ok );
        //
        else return Console::setMessage("The translator file is already existe" , Console::err );
    }
}
