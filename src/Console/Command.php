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

	// const NONE 	= "NONE";
	const VALUE 	= "VALUE";
	const OPTIONAL 	= "OPTIONAL";
	const REQUIRED 	= "REQUIRED";
	//
	protected $key;
	protected $command;

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
    	//
    	$this->setParams();
    }


    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$this->input = $input;
    	$this->output = $output;
        //
        $this->handle();
    }

    protected function Init()
    {
    	$this->setName($this->command);
    	$this->setDescription($this->description);
    }

    /**
     * Set members including command and args and options
     *
     * @return array
     */
    protected function anatomy()
    {
    	$this->members = Strings::splite($this->key," ");
    	$this->command = $this->members[0];
    	//
    	$y = "";
    	for ($i=1; $i < count($this->members) ; $i++) 
    		$y .= $this->members[$i]." ";
    	//
    	$rest2 = array();
    	$rest = Strings::splite($y,"} ");
    	for ($i=0; $i < count($rest)-1 ; $i++)
    		$rest2[] = $rest[$i]."}";
    	//
    	$this->members = $rest2;
    	return $this->members;
    }

    protected function params()
    {
    	$params = array();
    	//
    	for ($i=0; $i < count($this->members); $i++)
    		$params[] = $this->members[$i];
    	//
    	$this->params = $params;
    	return $params;
    }

    protected function strip($key)
    {
    	return substr($key, 1, -1);
    }

    protected function stripOpt($opt)
    {
    	return substr($opt, 2);
    }

    

    protected function setParams()
    {
    	$this->params();
    	// die(var_dump($this->params));
    	//
    	foreach ($this->params as $key => $value) 
    	{
    		$cont = $this->strip($value);
    		//
    		if(Strings::lenght($cont) > 2)
    		{
    			
    			if($cont[0] == "-" && $cont[1] == "-") $this->setOption($cont);
   				elseif($cont[0] != "-" && $cont[1] != "-") $this->setArgument($cont);
    		}
    		else 
    		{

    			$this->setArgument($cont);
    		} 
    			
    		
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
    		// die($key."a");
    		$name = substr($key, 0, -1);
    		$this->addArgument( $name, InputArgument::OPTIONAL);
    	}
    	else 
    	{
    		$this->addArgument( $key, InputArgument::REQUIRED,"");
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
    	return Strings::contains($arg," : ");
    }


    protected function setOption($opt)
    {
    	if($this->checkDiscription($opt)) $this->advenceOpt($opt);
    	else $this->simpleOpt($opt);
    }

    protected function simpleOpt( $opt , $disc="" )
    {

    	$type = $this->getOptionType($opt);
    	$key =$this->stripOpt($opt);
    	//
    	if($type == Commands::REQUIRED) 
    	{
    		$key = substr($key, 0, -1);
    		$this->addOption( $key , null , InputOption::VALUE_REQUIRED , $disc);
    	}
    	else if($type == Commands::OPTIONAL) 
    	{
    		$this->addOption( $key , null , InputOption::VALUE_NONE , $disc);
    	}
    	else if($type == Commands::VALUE) 
    	{
    		$value = $this->getOptionalValue($key);
    		//
    		$key = $this->getOptionalKeyValue($key);
    		//
    		$this->addOption( $key , null , InputOption::VALUE_OPTIONAL , $disc , $value);
    	}
    }

    protected function advenceOpt($opt)
    {

    	$data = Strings::splite($opt, " : ");

    	//
    	$opt = $data[0];
    	$disc = $data[1];
    	
    	//
    	$this->simpleOpt( $opt , $disc );
    }

    public function write($key)
    {
    	 $this->output->writeln($key);
    }

    public function arg($key)
    {
    	return $this->input->getArgument($key);
    }

    public function opt($key)
    {
    	return $this->input->getOption($key);
    }

    protected function isRequireValue($opt)
    {
    	return (substr($opt, -1) == "=");
    }

    protected function isOptionValue($opt)
    {
    	return (substr($opt, -1) == "?");
    }

    protected function getOptionType($opt)
    {
    	if(substr($opt, -1) == "=" ) return Commands::REQUIRED ;
    	else if(Strings::contains($opt , '=' )) return Commands::VALUE;
    	else return Commands::OPTIONAL;
    }

    protected function getOptionalValue($opt)
    {
    	$data = Strings::splite($opt,"=");
    	return $data[1];
    }

    protected function getOptionalKeyValue($opt)
    {
    	$data = Strings::splite($opt,"=");
    	return $data[0];
    }

    



}

