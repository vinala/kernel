<?php 

namespace Vinala\Kernel\MVC ;

use Vinala\Kernel\MVC\View\Exception\ViewNotFoundException;
use Vinala\Kernel\Atomium\Atomium;
use Vinala\Kernel\MVC\View\Template;

/**
* Views class
*/
class Views
{

	//--------------------------------------------------------
	// The properties
	//--------------------------------------------------------

	/**
	* The name of the view
	*
	* @var string 
	*/
	protected $name;


	/**
	* The path of the view
	*
	* @var string 
	*/
	protected $path;


	/**
	* The engine used in the view
	*
	* @var string 
	*/
	protected $engine;


	/**
	* Array od data passed to the view
	*
	* @var array 
	*/
	protected $data = array() ;


	/**
	* The nest path of all views
	*
	* @var string 
	*/
	protected $nest ;
	
	

	//--------------------------------------------------------
	// constuctor
	//--------------------------------------------------------

	function __construct()
	{
		$this->nest = root().'app/views/';
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Call a view
	*
	* @param string $name
	* @param array $data
	* @return Vinala\Kernel\MVC\Views
	*/
	public function call( $name , $data = null , $nest = null)
	{
		
		//Merge data
		if( ! is_null($data))
		{
			$this->data = array_merge( $this->data , $data);
		}		

		if( ! $this->exists($name , $nest))
		{
			throw new ViewNotFoundException($name);
		}
		else
		{
			$data = $this->exists($name , $nest);

			$this->path = $data['path'];
			$this->engine = $data['engine'];
			$this->nest = $nest;
		}

		$nameSegments = dot($name);

		$this->name = $this->setName($nameSegments);

		return $this;
	}

	/**
	* Extract name from dotted name segements
	*
	* @param array $name
	* @return string
	*/
	protected function setName($name)
	{
		return $name[count($name) - 1];
	}


	/**
	* Check if view exists
	*
	* @param string $name
	* @return array|false
	*/
	public function exists($name , $nest = null)
	{
		$file = str_replace('.', '/', $name);

		$extensions =[
			'.php',
			'.atom.php',
			'.atom',
			'.tpl.php'
		];

		$nest = $nest ?: $this->nest ;

		$i = 0;
		foreach ($extensions as $extension) 
		{
			$path = $nest.$file.$extension;

			if(file_exists($path))
			{
				if($i == 0) 
				{
					$view = ['path' => $path , 'engine' => 'none'];
				}
				elseif($i == 1 || $i == 2)
				{
					$view = ['path' => $path , 'engine' => 'atomium'];
				}
				elseif($i == 3)
				{
					$view = ['path' => $path , 'engine' => 'smarty'];
				}
				return $view;
			}

			$i++;
		}

		return false;
	}

	/**
	* Add variables to the view
	*
	* @param array|string $data
	* @param string $value
	* @return Vinala\Kernel\MVC\views
	*/
	public function with($data , $value = null)
	{
		if(is_string($data))
		{
			$this->data = array_merge( $this->data , [$data => $value]);
		}
		elseif(is_array($data))
		{
			$this->data = array_merge( $this->data , $data );
		}
		return $this;
	}

	/**
	* Show the view
	*
	* @return bool
	*/
	public function show(Views $_vinala_view = null)
	{

		if(is_null($_vinala_view))
		{
			$_vinala_view = $this;
		}

		if($_vinala_view->engine == 'atomium')
		{	
			self::atomium($_vinala_view->path , $_vinala_view->data , $_vinala_view->nest);
		}
		elseif($_vinala_view->engine == 'smarty')
		{
			Template::show($_vinala_view->path , $_vinala_view->data);
		}
		else
		{
			if( ! is_null($_vinala_view->data))
			{
				foreach ($_vinala_view->data as $_vinala_view_keys => $_vinala_view_values) 
				{
					$$_vinala_view_keys = $_vinala_view_values;
				}
			}

			include $_vinala_view->path;
		}

		return null;
	}

	/**
	* Show atomium view
	*
	* @param string $file
	* @param array $data
	* @return 
	*/
	protected function atomium($file, $data , $nest = null)
	{
		$atomium = new Atomium;

		return $atomium->show($file, $data , $nest);
	}


	
	
	


	
	
}