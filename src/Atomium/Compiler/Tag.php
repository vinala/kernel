<?php 

namespace Lighty\Kernel\Atomium\UserCompiler;

use Lighty\Kernel\Atomium\Compiler\AtomiumCompileInstructions;

/**
* 
*/
class Tag
{

	public static $target;
	public static $tag;
	public static $write = false;

	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		$called = get_called_class();
		//
		$result = "<?php ";
		$result .= $called::$write ? "echo " : "";
		$result .= $called::$target;
		//
		return AtomiumCompileInstructions::run($script, "@".$called::$tag, ";", $result,"; ?>");
	}
}