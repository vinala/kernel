<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Filesystem\Filesystem as File;

/**
* Controller class
*/
class Controller
{
	public static function create($name,$route = null,$rt = null)
	{
		// $addRoute = $Route;

		$Root = is_null($rt) ? Process::root : $rt ;
		//
		if(!file_exists($Root."app/controllers/$name.php")){
			$myfile = fopen($Root."app/controllers/$name.php", "w");
			$txt = self::set($name);
			fwrite($myfile, $txt);
			fclose($myfile);
			//
			if( !is_null($route)) 
			{
				self::addRoute($route , $name ,$Root);
			}

			return true;
		}
		else return false;

	}

	public static function set($class)
	{
		$txt = "<?php\n\n use Vinala\Kernel\MVC\Controller\Controller;\n\n";
		$txt.="/**\n* class de controller $class\n*/\n\nclass $class extends Controller\n{\n\t";

		//view
		$txt.="\n\t\n\tpublic static ".'$id = null'.";\n\tpublic static ".'$object = null'.";\n\n";

		//index
		$txt.="\n\t/**\n\t * Display a listing of the resource.\n\t *\n\t * \n\t * @return Response\n\t */";
		$txt.="\n\tpublic static function index()\n\t{\n\t\t//\n\t}";

		//show
		$txt.="\n\n\n\t/**\n\t * Get the resource by id\n\t *\n\t * @param id(mixed) id of the object \n\t * @return Response\n\t */";
		$txt.="\n\tpublic static function show(".'$id'.")\n\t{\n\t\t//\n\t}";

		//add
		$txt.="\n\n\n\t/**\n\t * Show the form for creating a new resource.\n\t *\n\t  * @return Response\n\t */";
		$txt.="\n\tpublic static function add()\n\t{\n\t\t//\n\t}";

		//insert
		$txt.="\n\n\n\t/**\n\t * Insert newly created resource in storage.\n\t *\n\t  * @return Response\n\t */";
		$txt.="\n\tpublic static function insert()\n\t{\n\t\t//\n\t}";

		//edit
		$txt.="\n\n\n\t/**\n\t * Show the form for editing the specified resource.\n\t *\n\t * @param id(mixed) id of the object \n\t * @return Response\n\t */";
		$txt.="\n\tpublic static function edit(".'$id'.")\n\t{\n\t\t//\n\t}";

		//update
		$txt.="\n\n\n\t/**\n\t * Update the specified resource in storage.\n\t *\n\t * @param id(mixed) id of the object \n\t * @return Response\n\t */";
		$txt.="\n\tpublic static function update(".'$id=null'.")\n\t{\n\t\t//\n\t}";

		//delete
		$txt.="\n\n\n\t/**\n\t * Delete the specified resource in storage.\n\t *\n\t * @param id(mixed) id of the object \n\t * @return Response\n\t */";
		$txt.="\n\tpublic static function delete(".'$id'.")\n\t{\n\t\t//\n\t}";

		$txt.="\n}";
		return $txt;
	}

	/**
	* Add controller route to routes file
	*
	* @param string $route
	* @param string $controller
	* @return bool
	*/
	public static function addRoute($route , $controller , $root)
	{
		$file 	= $root."app/http/Routes.php";
		$content 	 = "\n\ntarget('$route','$controller');";

		file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

		return true;
	}
	

	/** 
	*	Listing all schemas
	*/
	public static function ListAll()
	{
		$controllers = glob(Application::$root."app/controllers/*.php");
		//
		return $controllers;
	}

	/**
	* clear all controllers created
	* @return bool
	*/
	public static function clear()
	{
		$files = File::glob(Application::$root."app/controllers/*");
		//
		foreach ($files as $file) 
			File::delete($file);
		//
		return true;
	}
	
}