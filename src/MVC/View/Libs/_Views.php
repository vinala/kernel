<?php 

namespace Vinala\Kernel\MVC ;

use Vinala\Kernel\MVC\View\Exception\ViewNotFoundException;

/**
* Views class
*/
class Views
{
	//--------------------------------------------------------
	// Constantes
	//--------------------------------------------------------

	const NEST = root().'app/views/';


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
	* Array od data passed to the view
	*
	* @var array 
	*/
	protected $data = array() ;
	

	//--------------------------------------------------------
	// constuctor
	//--------------------------------------------------------

	function __construct()
	{
		
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
	public function make( $name , $data = null)
	{
		//Merge data
		$this->data = array_collapse( $this->data , $data);

		if( ! $this->exists($name))
		{
			throw new ViewNotFoundException($name);
		}
		else
		{
			$this->path = $this->exists($name);
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
	* @return bool
	*/
	public function exists($name)
	{
		$file = str_replace('.', '/', $name);

		$extensions =[
			'.php',
			'.atom.php',
			'.atom',
			'.tpl.php'
		];

		foreach ($extensions as $extension) 
		{
			$path = self::NEST.$file.$extension;

			if(file_exists($path))
			{
				return $path;
			}
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
			$this->data = array_collapse( $this->data , [$data => $value]);
		}
		elseif(is_array($data))
		{
			$this->data = array_collapse( $this->data , $data );
		}
		return $this;
	}
	
	


	
	
}