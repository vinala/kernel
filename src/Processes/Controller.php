<?php 

namespace Lighty\Kernel\Process;

use Lighty\Kernel\Process\Process;
use Lighty\Kernel\Foundation\Application;

/**
* Controller class
*/
class Controller
{
	public static function create($fileName,$className,$Route,$rt = null)
	{
		$addRoute = $Route;
		$class = $className;
		$file = $fileName;
		$Root = is_null($rt) ? Process::root : $rt ;
		//
		if(!file_exists($Root."app/controllers/$file.php")){
			$myfile = fopen($Root."app/controllers/$file.php", "w");
			$txt = self::set($class);
			fwrite($myfile, $txt);
			fclose($myfile);
			//
			self::addRoute($addRoute,$className , $fileName ,$Root);
			return true;
		}
		else return false;

	}

	public static function set($class)
	{
		$txt = "<?php\n\n use Lighty\Kernel\MVC\Controller\Controller;\n\n";
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

	public static function addRoute($addRoute , $className , $fileName ,$Root)
	{
		if($addRoute)
		{
			$RouterFile 	= $Root."app/http/Routes.php";
			$RouterContent 	 = "\n\n";
			$RouterContent 	.= 'Route::controller("'.$fileName.'","'.$className.'");';
			//
			file_put_contents($RouterFile, $RouterContent, FILE_APPEND | LOCK_EX);
		}
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
}