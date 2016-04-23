<?php

namespace Pikia\Kernel\Console\Command;

use Pikia\Kernel\Objects\Strings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Commands extends Command
{

	protected $key ;

	protected $description ;

	protected $members = array() ;
	protected $params = array() ;

	protected $input;
	protected $output;

    /**
     * Configure de command
    */ 
    protected function configure()
    {

    	$this->anatomy();
    	//
    	$this->Init();
    	$this->setParams();
    	// $this->setParams();

        // $this
        //     ->setName($this->key))
        //     ->setDescription($this->$description);

        //     ->addArgument( 'fileName', InputArgument::REQUIRED, 'what\'s the name of the file?')
        //     ->addArgument( 'className', InputArgument::REQUIRED, 'what\'s the name of the controller class?')
        //     ->addOption(
        //        'route',
        //        null,
        //        InputOption::VALUE_NONE,
        //        'If set, a router for this controller will created in routes file'
        //     );
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$this->input = $input;
    	$this->output = $output;
        // $fileName = $input->getArgument('fileName');
        // $className = $input->getArgument('className');
        // $addRoute = $input->getOption('route');
        // //
        // $process = Controller::create($fileName , $className , $addRoute);
        // //
        // $msg = self::message($process);
        // //
        // $output->writeln($msg);

        //
        $this->handle();
    }

    protected function Init()
    {
    	// die(var_dump($this));
    	//
    	$command = $this->members[0];
    	// die(var_dump($this->members));
    	//
    	$this->setName($command);
    	$this->setDescription($this->description);
    }

    protected function anatomy()
    {
    	$this->members = Strings::splite($this->key," ");
    	// die(var_dump($this->members));
    	return $this->members;
    }

    protected function params()
    {
    	$params = array();
    	//
    	for ($i=1; $i < count($this->members); $i++)
    		$params[] = $this->members[$i];
    	//
    	$this->params = $params;
    	return $params;
    }

    protected function strip($key)
    {
    	return substr($key, 1, -1);
    }

    

    protected function setParams()
    {
    	$this->params();
    	//
    	foreach ($this->params as $key => $value) 
    	{
    		$cont = $this->strip($value);
    		//
    		if($cont[0] == "-" && $cont[1] == "-") $this->setOption($cont);
   			elseif($cont[0] != "-" && $cont[1] != "-") $this->setArgument($cont);
    	}
    }

    protected function setArgument($arg)
    {
    	if($this->checkDiscription($arg)) $this->advenceArg($arg);
    	else $this->simpleArg($arg);
    }

    protected function isOption($arg)
    {
    	return (substr($arg, -1) == "?");
    }

	protected function simpleArg($key)
    {
    	if($this->isOption($key)) 
    	{
    		$name = substr($key, 0, -1);
    		$this->addArgument( $name, InputArgument::OPTIONAL);
    	}
    	else 
    	{
    		$this->addArgument( $key, InputArgument::REQUIRED);
    	}
    }

	protected function advenceArg($key)
    {
    	$data = Strings::splite($key, " : ");
    	$arg = $data[0];
    	$disc = $data[1];
    	//
    	if($this->isOption($arg)) 
    	{
    		$name = substr($arg, 0, -1);
    		$this->addArgument( $name, InputArgument::OPTIONAL , $disc);
    	}
    	else 
    	{
    		$this->addArgument( $arg, InputArgument::REQUIRED , $disc);
    	}
    }

    protected function checkDiscription($arg)
    {
    	return Strings::contains($arg,":");
    }


    protected function setOption($opt)
    {
    	# code...
    }

    public function write($key)
    {
    	 $this->output->writeln($key);
    }

    public function arg($key)
    {
    	return $this->input->getArgument($key);
    }

    



}

