<?php 

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Foundation\Application;

/**
* Exception class
*/
class Events
{

	/**
	* Create exception
	*
	* @param string $name
	* @param string $message
	* @param string $view
	* @return bool
	*/
	public static function create($name)
	{
		$root = Process::root;
		//
		if(!file_exists($root."app/events/$name.php")){
			$file = fopen($root."app/events/$name.php", "w");
			$txt = self::set($name);
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
	protected static function set($name)
	{
		$txt = "<?php\n\n";
		$txt .= "namespace Vinala\App\Events;\n\n";
		$txt .= "use Vinala\Kernel\Events\EventListener as Listener;\n\n";
		$txt .= "/**\n* ".$name." Event\n*/\n";
		$txt .= "class $name extends Listener\n{\n\n";
		$txt .= self::eventArray();
		$txt .= self::eventFunction();
		$txt .= "}";

		return $txt;
	}

	/**
	* Generate events array
	*
	* @return string
	*/
	protected static function eventArray()
	{
		$txt = "\t/**\n\t* Set events pattern and thier function\n\t*\n\t* @var array\n\t*/\n\t";

		$txt .= 'public static $events = ['."\n\t\t'someEvent' => 'onSomeEvent',\n\t];\n\n\n\n";

		return $txt;
	}

	/**
	* Generate events function
	*
	* @return string
	*/
	protected static function eventFunction()
	{
		$txt = "\t/**\n\t* Event function\n\t*/\n\t";

		$txt .= 'public function onSomeEvent()'."\n\t{\n\t\t// Do something \n\t}\n\n";

		return $txt;
	}
	
	

}