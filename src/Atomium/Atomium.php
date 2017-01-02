<?php 

namespace Vinala\Kernel\Atomium;

use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Security\Hash;
use Vinala\Kernel\Objects\Strings;
use Vinala\Kernel\MVC\View\Views;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileCapture;
use Vinala\Kernel\Atomium\Exception\AromiumCaptureNotFoundException;

class Atomium
{

	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	/**
	 * Path were template stored
	 *
	 * @var string
	 */
	protected $TemplateDir;

	/**
	 * the reel template
	 *
	 * @var string
	 */
	protected $templateFile;

	/**
	 * template file
	 *
	 * @var string
	 */
    protected $file;

    /**
	 * template vars
	 *
	 * @var array
	 */
    protected $values = array();
  

  	//--------------------------------------------------------
  	// Functions
  	//--------------------------------------------------------

    /**
     * Set template directory
     */
    protected function setTemplateDir($TemplateDir = null) 
    {
        if( ! is_null($TemplateDir)) 
        {
        	$this->TemplateDir = $TemplateDir;	
        }
        else 
        {
        	$this->TemplateDir = Application::$root."app/storage/framework/view/template/atomium";
        }
    }

    /**
    * show the template
    *
    * @param string $file
    * @param array $data
    * @param string $nest
    * @return null
    */
    public function show($file, $data , $nest = null) 
    {
    	$this->setTemplate($file);
    	//
    	$this->assign($data);

    	$nest = ! is_null($nest) ?: '../app/';
    	//
    	$this->setTemplateDir($nest.'storage/framework/view/template/atomium');
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
	protected function store($content,$name = null)
	{
		$name = (is_null($name)) ? $this->name() : $name;
		$file = fopen($this->TemplateDir."/".$name, "w");
		//
		fwrite($file, $content);
		fclose($file);
		//
		return $this->TemplateDir."/".$name;
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
	protected function name($name = null)
	{
		$filename = is_null($name) ? $this->filename() : $name;
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
		foreach ($this->values as $key => $value) $$key = $value;
		//
		require_once  $this->TemplateDir.'/'.$this->templateFile;
	}

	/**
	 * get a the full open tag of capture
	 */
	protected function switcher($view, $capture, $viewName)
	{
		if(Strings::contains($view, "@capture('$capture')")) return "@capture('$capture'):";
		elseif(Strings::contains($view, '@capture("'.$capture.'")')) return '@capture("'.$capture.'"):';
		else throw new AromiumCaptureNotFoundException($capture, $viewName);
	}

	/**
	 * get a capture
	 */
	public function call($view, $capture, $data = null)
	{
		$viewName = $view;
		$name = $this->name($view."_capture_".$capture);
		$view = self::get($view);

		//
		$capture = self::switcher($view, $capture, $viewName);
		//
		$view = AtomiumCompileCapture::call($view, $capture);
		//
		if( ! is_null($data))
			foreach ($data as $key => $value) 
				$$key = $value;
		//
		$content = Compiler::output($view);
		include $this->store($content,$name);
	}

	/**
	 * get a atomium viewview
	 */
	public function get($view)
	{
		$file=str_replace('.', '/', $view);
		//
		$link1=Application::$root.'app/views/'.$file.'.atom.php';
		$link2=Application::$root.'app/views/'.$file.'.atom';
		//
		if(file_exists($link1)) { $link3 = $link1;  }
		else if(file_exists($link2)) { $link3 = $link2;  }
		//
		$content = file_get_contents($link3);
		//
		return $content;
	}
}