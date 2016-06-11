<?php 

namespace Lighty\Kernel\Atomium\Compiler;

use Lighty\Kernel\Objects\Strings;
use Lighty\Kernel\Objects\Table;

/**
* 
*/
class AtomiumCompileIf
{

	/**
	 * The tag that open the instruction 
	 *
	 * @var string
	 */
	protected static $openTag = "@if";


	/**
	 * The key where open tag end's
	 *
	 * @var string
	 */
	protected static $endOpenTag = "\n";


	/**
	 * The tag that close the instruction 
	 *
	 * @var string
	 */
	protected static $closeTag = "@endif";


	/**
	 * The PHP Open tag that should Lighty replace with
	 *
	 * @var string
	 */
	protected static $phpOpenTag = "<?php if ";


	/**
	 * The key where PHP Open tag end's
	 *
	 * @var string
	 */
	protected static $phpEndOpenTag = ": ?>";


	/**
	 * The PHP Close tag that should Lighty replace with
	 *
	 * @var string
	 */
	protected static $phpCloseTag = "<?php endif; ?>";

	
	/**
	 * Complie the opening tag
	 *
	 * @var string
	 */
	protected static function openTag($script)
	{
		return AtomiumCompileInstruction::openTag($script, self::$openTag, self::$closeTag, self::$phpOpenTag, self::$endOpenTag, self::$phpEndOpenTag);	
	}

	
	/**
	 * Complie the closing tag
	 *
	 * @var string
	 */
	protected static function closeTag($script)
	{
		return AtomiumCompileInstruction::closeTag($script, self::$closeTag, self::$phpCloseTag);
	}

	
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		$script = self::openTag($script);
		$script = self::closeTag($script);
		return $script;
	}
}