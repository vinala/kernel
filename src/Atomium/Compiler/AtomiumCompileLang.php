<?php 

namespace Vinala\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileLang
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileInstructions::run($script, "@lang", ";", "<?php echo Translator::get(" ,"); ?>");
	}
}