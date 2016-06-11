<?php 

namespace Lighty\Kernel\Atomium;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Security\Hash;
use Lighty\Kernel\Objects\Strings;

class Atomium
{

	/**
	 * Path were template stored
	 */
	protected $TemplateDir;

	/**
	 * the reel template
	 */
	protected $templateFile;

	/**
	 * template file
	 */
    protected $file;

    /**
	 * template vars
	 */
    protected $values = array();
  
    /**
     * Set template directory
     */
    protected function setTemplateDir($TemplateDir = null) 
    {
        if( ! is_null($TemplateDir)) $this->TemplateDir = $TemplateDir;
        else $this->TemplateDir = Application::$root."app/storage/framework/view/template/atomium";
    }

    /**
     * Set View file
     */
    public function show($file, $data) 
    {
    	$this->setTemplate($file);
    	//
    	$this->assign($data);
    	//
    	$this->setTemplateDir();
    	//
    	$this->store($this->compile());
    	//
    	$this->display();
    }

    /**
     * Set View file
     */
    protected function setTemplate($file) 
    {
        $this->file = $file;
    }

    /**
	 * set arrays vars
	 */
    protected function assign($data) 
    {
    	if( ! is_null($data))
    	foreach ($data as $key => $value) 
    		$this->set($key, $value);
	}

    /**
	 * set template vars
	 */
    protected function set($key, $value) 
    {
    	$this->values[$key] = $value;
	}
	  
	/**
	 * store compiled template file
	 */
	protected function store($content)
	{
		$name = $this->name();
		$file = fopen($this->TemplateDir."/".$name, "w");
		//
		fwrite($file, $content);
		fclose($file);
	}

	/**
	 * hash template file
	 */
	protected function hash($file)
	{
		return Hash::make($file);
	}

	/**
	 * template file name
	 */
	protected function name()
	{
		$filename = $this->filename();
		$hash = Hash::make($filename);
		$name = $hash."_".$filename;
		//
		$this->templateFile = $name ;
		//
		return $name;
	}

	/**
	 * compile template file
	 */
	protected function compile()
	{
		return Compiler::run($this->file , $this->values);
	}

	/**
	 * get file name
	 */
	protected function filename()
	{
		$data = Strings::splite($this->file , "/");
		return $data[count($data)-1];
	}

	/**
	 * display the view
	 */
	protected function display()
	{
		// if( ! is_null($data))
		foreach ($this->values as $key => $value) $$key = $value;
		//
		require_once  $this->TemplateDir.'/'.$this->templateFile;
	}
}