<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Foundation\Application;

/**
* Exception class
*/
class Exception
{

	/**
	* Create exception
	*
	* @param string $name
	* @param string $message
	* @param string $view
	* @return bool
	*/
	public static function create($name , $message , $view)
	{
		$root = Process::root;
		//
		if(!file_exists($root."app/exceptions/$name.php")){
			$file = fopen($root."app/exceptions/$name.php", "w");
			$txt = self::set($name , $message , $view);
			fwrite($file, $txt);
			fclose($file);
			//
			return true;
		}
		else return false;
	}

	/**
	* Build the class script
	*
	* @param string $name
	* @param string $message
	* @param string $view
	* @return string
	*/
	protected static function set($name , $message , $view)
	{
		$txt = "<?php\n\n";
		$txt .= "namespace Vinala\App\Exception;\n\n";
		$txt .= "use Vinala\Kernel\Logging\Exception;\n\n";
		$txt .= "/**\n* ".$name." Exception\n*/\n";
		$txt .= "class $name extends Exception\n{\n\n";
		$txt .= "\tfunction __construct()\n\t{";
		$txt .= "\n\t\t".'$this->message = '."'$message';";
		$txt .= "\n\t\t".'$this->view = '."'$view';";
		$txt .= "\n\t}\n\n}";

		return $txt;
	}
	

}