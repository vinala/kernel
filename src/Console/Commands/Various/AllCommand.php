<?php 

namespace Fiesta\Kernel\Console\Command\Various;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fiesta\Kernel\Console\Console;



class AllCommand extends Command
{
    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this
            ->setName('all')
            ->setDescription('All Pikia commands');
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = $this->all();
        //
        // $msg = self::message($process);
        //
        $output->writeln($msg);
    }


    /**
     * Format the message to show
    */
    protected static function message($process)
    {
        if($process == 1) return Console::setMessage("The view is created" , Console::lst );
        else if($process == 2) return Console::setMessage("The view is already existe" , Console::err );
            //"Le fichier deja existe"
        else if($process == 3) return Console::setMessage("The view is already existe" , Console::err );
    }

    /**
     * Format the message to show
    */
    protected function all()
    {
        $process = "\n";
        //
        $process .=Console::setMessage(" info............Get info about the framework\n" , Console::nn );
        $process .=Console::setMessage(" all.............All Pikia commands\n" , Console::nn );
        $process .=Console::setMessage("schema\n" , Console::lst );
        $process .=Console::setMessage(" :new............make new schema file...............|".Console::setCyan("  <name>\n") , Console::nn );
        $process .=Console::setMessage(" :exec...........Execute the last schema created\n" , Console::nn );
        $process .=Console::setMessage(" :rollback.......Rollback the last schema created\n" , Console::nn );
        $process .=Console::setMessage("lang\n" , Console::lst );
        $process .=Console::setMessage(" :new:dir........make new translator directory......|".Console::setCyan("  <name>\n") , Console::nn );
        $process .=Console::setMessage(" :new:file.......make new translator file...........|".Console::setCyan("  <fileName> <dirName>\n") , Console::nn );
        $process .=Console::setMessage("link\n" , Console::lst );
        $process .=Console::setMessage(" :new............New file for links.................|".Console::setCyan("  <fileName>\n") , Console::nn );
        $process .=Console::setMessage("model\n" , Console::lst );
        $process .=Console::setMessage(" :new............New model..........................|".Console::setCyan("  <fileName> <className> <tableName>\n") , Console::nn );
        $process .=Console::setMessage("view\n" , Console::lst );
        $process .=Console::setMessage(" :new............New View...........................|".Console::setCyan("  <fileName>  --smarty\n") , Console::nn );
        $process .=Console::setMessage("controller\n" , Console::lst );
        $process .=Console::setMessage(" :new............New Controller.....................|".Console::setCyan("  <fileName> <className>  --addRoute\n") , Console::nn );
        $process .=Console::setMessage("seed\n" , Console::lst );
        $process .=Console::setMessage(" :new............New Seeder.........................|".Console::setCyan("  <name> <tableName>\n") , Console::nn );
        $process .=Console::setMessage(" :exec...........Execute Seeder\n" , Console::nn );
        $process .=Console::setMessage("routes\n" , Console::lst );
        $process .=Console::setMessage(" :get............Add new get route to Routes file...|".Console::setCyan("  <route>\n") , Console::nn );
        //
        return $process;

    }
}
