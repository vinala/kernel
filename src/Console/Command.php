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

	const VALUE 	= "VALUE";
	const OPTIONAL 	= "OPTIONAL";
	const REQUIRED 	= "REQUIRED";
	//
	/**
	 * User Key
	 * @var string
	 */
	protected $key;

	/**
	 * command name
	 * @var string
	 */
	protected $command;

	/**
	 * command description
	 * @var string
	 */
	protected $description ;

	/**
	 * all separted strings in the key
	 * @var string
	 */
	protected $members = array() ;

	/**
	 * all args and options in key
	 * @var string
	 */
	protected $params = array() ;

	/**
	 * the console input
	 * @var InputInterface
	 */
	protected $input;

	/**
	 * the console input
	 * @var OutputInterface
	 */
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

    /**
     * Init the command setting the name and description
     */
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

    /**
     * get the params from members
     */
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

    /**
     * remove brackets
     */
    protected function strip($key)
    {
    	return substr($key, 1, -1);
    }

    /**
     * remove dashes from option key
     */
    protected function stripOpt($opt)
    {
    	return substr($opt, 2);
    }

    /**
     * set the args and options
     */
    protected function setParams()
    {
    	$this->params();
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

    /**
     * set the args and check if ther is description
     */
    protected function setArgument($arg)
    {
    	if($this->checkDiscription($arg)) $this->advanceArg($arg);
    	else $this->simpleArg($arg);
    }

    /**
     * check if arg is optional
     */
    protected function isOption($arg)
    {
    	return (substr($arg, -1) == "?");
    }

    /**
     * set simple arg with optional description
     */
	protected function simpleArg($key , $desc = "")
    { 
    	if($this->isOption($key)) 
    	{
    		$name = substr($key, 0, -1);
    		$this->addArgument( $name, InputArgument::OPTIONAL,$desc);
    	}
    	else 
    	{
    		$this->addArgument( $key, InputArgument::REQUIRED,$desc);
    	}
    }

    /**
     * set advanced arg with required description
     */
	protected function advanceArg($key)
    {
    	$data = Strings::splite($key, " : ");
    	//
    	$arg = $data[0];
    	$desc = $data[1];
    	//
    	$this->simpleArg($arg , $desc);
    }

    /**
     * check if their is description
     */
    protected function checkDiscription($arg)
    {
    	return Strings::contains($arg," : ");
    }

    /**
     * check if ther is description
     */
    protected function setOption($opt)
    {
    	if($this->checkDiscription($opt)) $this->advanceOpt($opt);
    	else $this->simpleOpt($opt);
    }

    /**
     * set simple option with optional description
     */
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

    /**
     * set advanced option with optional description
     */
    protected function advanceOpt($opt)
    {
    	$data = Strings::splite($opt, " : ");
    	//
    	$opt = $data[0];
    	$disc = $data[1];
    	//
    	$this->simpleOpt( $opt , $disc );
    }

    /**
     * to write in the console
     */
    public function write($key)
    {
    	 $this->output->writeln($key);
    }

    /**
     * to get argument
     */
    public function argument($key)
    {
    	return $this->input->getArgument($key);
    }

    /**
     * to get option
     */
    public function option($key)
    {
    	return $this->input->getOption($key);
    }

    /**
     * check if value is required in option
     */
    protected function isRequireValue($opt)
    {
    	return (substr($opt, -1) == "=");
    }

    /**
     * check if vlue is optional in option
     */
    protected function isOptionValue($opt)
    {
    	return (substr($opt, -1) == "?");
    }

    /**
     * get the type of the option
     */
    protected function getOptionType($opt)
    {
    	if(substr($opt, -1) == "=" ) return Commands::REQUIRED ;
    	else if(Strings::contains($opt , '=' )) return Commands::VALUE;
    	else return Commands::OPTIONAL;
    }
}