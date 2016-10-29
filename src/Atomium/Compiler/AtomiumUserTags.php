<?php 

namespace Vinala\Kernel\Atomium\UserCompiler;

use Vinala\Kernel\Atomium\Compiler\AtomiumCompileInstructions;

/**
* Mother class of user Atomium Tags
*/
class AtomiumUserTags
{
	/**
	 * The function that Atomium should replace it
	 */
	protected static $target;

	/**
	 * The tag that Atomium should replace it by the function
	 */
	protected static $tag;

	/**
	 * if set true Atomium will echo the returned value from the function
	 */
	protected static $write = false;

	/**
	 * run the compiler
	 *
	 * @var string
	 * @return string
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