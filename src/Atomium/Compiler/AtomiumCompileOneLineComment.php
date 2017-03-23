<?php 

namespace Vinala\Kernel\Atomium\Compiler;

use Vinala\Kernel\String\Strings;
use Vinala\Kernel\Collections\Collection;

/**
* 
*/
class AtomiumCompileOneLineComment
{

	/**
	 * The tag that open the instruction 
	 *
	 * @var string
	 */
	protected static $openTag = "///";


	/**
	 * The tag that close the instruction 
	 *
	 * @var string
	 */
	protected static $closeTag = "\n";


	/**
	 * Complie the opening tag
	 *
	 * @var string
	 */
	protected static function hide($script)
	{
		return AtomiumCompileComments::hide($script, self::$openTag, self::$closeTag);
	}

	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		$script = self::hide($script);
		return $script;
	}
}