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
	public static function create($name,$route = null , $resources , $rt = null)
	{
		// $addRoute = $Route;

		$Root = is_null($rt) ? Process::root : $rt ;
		//
		if(!file_exists($Root."app/controllers/$name.php")){
			$myfile = fopen($Root."app/controllers/$name.php", "w");
			$txt = self::set($name , $resources);
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

	public static function set($class , $resources = false)
	{
		$txt = "<?php\n\nuse Vinala\Kernel\MVC\Controller;\n\n";
		$txt.="/**\n* class de controller $class\n*/\nclass $class extends Controller\n{";

		//view
		// $txt.="\n\t\n\tpublic static ".'$id = null'.";\n\tpublic static ".'$object = null'.";\n\n";
		if($resources)
		{
			//index
			$txt.="\n\n\t/**\n\t* Display a listing of the resource.\n\t*\n\t* \n\t* @return Response\n\t*/";
			$txt.="\n\tpublic static function index()\n\t{\n\t\t//\n\t}";

			//show
			$txt.="\n\n\n\t/**\n\t* Get the resource by id\n\t*\n\t* @param int ".'$id'."\n\t* @return Response\n\t*/";
			$txt.="\n\tpublic static function show(".'$id'.")\n\t{\n\t\t//\n\t}";

			//add
			$txt.="\n\n\n\t/**\n\t* Show the form for creating a new resource.\n\t*\n\t* @return Response\n\t*/";
			$txt.="\n\tpublic static function add()\n\t{\n\t\t//\n\t}";

			//insert
			$txt.="\n\n\n\t/**\n\t* Insert newly created resource in storage.\n\t*\n\t* @param Vinala\Kernel\Http\Request ".'$req'." \n\t* @return Response\n\t*/";
			$txt.="\n\tpublic static function insert(Request ".'$req'.")\n\t{\n\t\t//\n\t}";

			//edit
			$txt.="\n\n\n\t/**\n\t* Show the form for editing the specified resource.\n\t*\n\t* @param int ".'$id'."\n\t* @return Response\n\t*/";
			$txt.="\n\tpublic static function edit(".'$id'.")\n\t{\n\t\t//\n\t}";

			//update
			$txt.="\n\n\n\t/**\n\t* Update the specified resource in storage.\n\t*\n\t* @param Vinala\Kernel\Http\Request ".'$req'." \n\t* @param int ".'$id'." \n\t* @return Response\n\t*/";
			$txt.="\n\tpublic static function update(".'Request $req , $id'.")\n\t{\n\t\t//\n\t}";

			//delete
			$txt.="\n\n\n\t/**\n\t* Delete the specified resource in storage.\n\t*\n\t* @param int ".'$id'."\n\t* @return Response\n\t*/";
			$txt.="\n\tpublic static function delete(".'$id'.")\n\t{\n\t\t//\n\t}";

		}
		else
		{
			$txt .= "\n\t//";
		}

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