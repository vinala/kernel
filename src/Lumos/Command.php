<?php

namespace Vinala\Kernel\Console\Command;

use Vinala\Kernel\Objects\Strings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Vinala\Kernel\Config\Config;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Helper\Table;
use Vinala\Kernel\Console\Argument;
use Vinala\Kernel\Console\Option;
use Vinala\Kernel\Database\Database;
use LogicException;



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
     * if the command will use database
     * @var bool
     */
    protected $database = false;

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
     * all args and options in key
     * @var array
     */
    public $inputs = array() ;

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
     * the console type
     * @var mixed
     */
    protected $console;

    /**
     * Configure de command
    */ 
    protected function configure()
    {
        $this->checkSet();
        //
    	$this->anatomy();
    	//
    	$this->Init();
    	//
    	$this->setParams();
    }

    /**
     * Check if there is a set function to set key and description
     */
    protected function checkSet()
    {
        if(method_exists ($this,"set")) $this->set();
    }

    /**
     * Execute de command
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$this->input = $input;
    	$this->setOutput($output);
        //
        if($this->database && config('components.database'))
        {
            Database::ini();
        } 
        elseif($this->database && ! config('components.database'))
        {
            exception(LogicException::class , 'The database surface is disabled');
        }
        //
        $this->handle();
    }

    /**
     * Execute de command
    */
    protected function setOutput(OutputInterface $output)
    {
        switch (Config::get("lumos.terminal")) {
            case 'bash': $op = new bashOutput($output); break;
            case 'cmd': $op = new cmdOutput($output); break;
            default: $op = new bashOutput($output); break;
        }
        //
        $this->console = $op;
        $this->output = $op->output;
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
    		if(Strings::length($cont) > 2)
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
            $this->addArgumentInput( $name, InputArgument::OPTIONAL,$desc);
    	}
    	else 
    	{
    		$this->addArgument( $key, InputArgument::REQUIRED,$desc);
            $this->addArgumentInput( $key, InputArgument::REQUIRED,$desc);
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
     * add ARgument to inputs array
     */
    protected function addArgumentInput($name, $requirement , $description = "")
    {
        $this->inputs[] = new Argument($name, $requirement , $description);
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
            $this->addOptionInput($key, InputOption::VALUE_REQUIRED, $disc);
    	}
    	else if($type == Commands::OPTIONAL) 
    	{
    		$this->addOption( $key , null , InputOption::VALUE_NONE , $disc);
            $this->addOptionInput($key, InputOption::VALUE_NONE, $disc);
    	}
    	else if($type == Commands::VALUE) 
    	{
    		$value = $this->getOptionalValue($key);
    		//
    		$key = $this->getOptionalKeyValue($key);
    		//
    		$this->addOption( $key , null , InputOption::VALUE_OPTIONAL , $disc , $value);
            $this->addOptionInput($key, InputOption::VALUE_OPTIONAL, $disc, $value);
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
     * add Option to inputs array
     */
    protected function addOptionInput($name, $requirement = null, $description = "", $value = null)
    {
        $this->inputs[] = new Option($name, $requirement, $description, $value);
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

    /**
     * get the value of option
     */
    protected function getOptionalValue($opt)      
    {     
        $data = Strings::splite($opt,"=");      
        return $data[1];        
    }     
      
    /**
     * get the name of option
     */
    protected function getOptionalKeyValue($opt)      
    {     
        $data = Strings::splite($opt,"=");      
        return $data[0];        
    }

    /**
     * to write in the console
     */
    public function line($text = "")
    {
        $this->output->writeln($text);
    }

    /**
     * to write in the console
     */
    public function write($key)
    {
         $this->output->write($key);
    }

    /**
     * to write text in green color in the console
     */
    public function info($text , $sameLine = false)
    {
        $output = $this->console->info($text);
        //
        if($sameLine) $this->console->write($output);
        else $this->console->line($output);
    }

    /**
     * to write text in yellow color in the console
     */
    public function comment($text , $sameLine = false)
    {
        $output = $this->console->comment($text);
        //
        if($sameLine) $this->console->write($output);
        else $this->console->line($output);
    }

    /**
     * to write text in cyan color in the console
     */
    public function question($text , $sameLine = false)
    {
        $output = $this->console->question($text);
        //
        if($sameLine) $this->console->write($output);
        else $this->console->line($output);
    }

    /**
     * to write text in red color in the console
     */
    public function error($text , $sameLine = false)
    {
        $output = $this->console->error($text);
        //
        if($sameLine) $this->console->write($output);
        else $this->console->line($output);
    }

    /**
     * to write text in red color in the console
     */
    public function red($text , $sameLine = false)
    {
        $output = $this->console->red($text);
        //
        if($sameLine) $this->console->write($output);
        else $this->console->line($output);
    }

    /**
     * to write text in green color in the console
     */
    public function green($text , $sameLine = false)
    {
        $output = $this->console->green($text);
        //
        if($sameLine) $this->console->write($output);
        else $this->console->line($output);
    }

    /**
    * Show to Vinala lumos title
    *
    * @param string $title
    * @return null
    */
    public function title($sub = '' , $title = 'Vinala Lumos')
    {
        if($title != '')
        {
            $this->console->line("\n".$title);
            //
            $underline = '';
            for ($i=0; $i < strlen($title); $i++) { 
                $underline .= '=';
            }
            //
            $this->console->line($underline);
        }
        //
        if($sub != '')
        {
            $this->console->line("\n".$sub);
        }
    }
    

    /**
     * ask user for some information
     */
    public function ask($text,$response = "")
    {
        $helper = $this->getHelper('question');
        //
        $question = new Question($this->console->question($text." "), $response);
        //
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * ask user for confirmation
     */
    public function confirm($text,$default = false)
    {
        $helper = $this->getHelper('question');
        //
        $question = new ConfirmationQuestion($this->console->question($text." "), $default);
        //
        return $helper->ask($this->input, $this->output, $question);
    }


    /**
     * ask user for password
     */
    public function hidden($text)
    {
        $helper = $this->getHelper('question');
        //
        $question = new Question($this->console->question($text." "));
        //
        $question->setHidden(true);
        //
        $question->setHiddenFallback(true);
        //
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * ask user for some information
     */
    public function choice($text,$choices)
    {
        $helper = $this->getHelper('question');
        //
        $question = new ChoiceQuestion($this->console->question($text." "),$choices,false);
        //
        $question->setErrorMessage("Your choice '%s' is invalid.");
        //
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * display Table
     */
    public function table($header,$data)
    {
        $table = new Table($this->output);
        //
        $table->setHeaders($header)->setRows($data);
        //
        $table->render();
    }

}