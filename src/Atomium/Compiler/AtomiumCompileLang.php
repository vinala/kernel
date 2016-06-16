<?php 

namespace Lighty\Kernel\Atomium\Compiler;

use Lighty\Kernel\Objects\Strings;
use Lighty\Kernel\Objects\Table;

/**
* 
*/
class AtomiumCompileLang
{

	/**
	 * The tag that open the instruction 
	 *
	 * @var string
	 */
	protected static $openTag = "@lang";


	/**
	 * The key where open tag end's
	 *
	 * @var string
	 */
	protected static $endOpenTag = ";";


	/**
	 * The PHP Open tag that should Lighty replace with
	 *
	 * @var string
	 */
	protected static $phpOpenTag = "<?php echo Translator::get(" ;


	/**
	 * The key where PHP Open tag end's
	 *
	 * @var string
	 */
	protected static $phpEndOpenTag = "); ?> " ;


	/**
	 * Complie the opening tag
	 *
	 * @var string
	 */
	protected static function openTag($script)
	{
		return AtomiumCompileOneLineInstruction::run($script, self::$openTag, self::$phpOpenTag, self::$endOpenTag, self::$phpEndOpenTag);
	}


	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		$script = self::openTag($script);
		return $script;
	}
}