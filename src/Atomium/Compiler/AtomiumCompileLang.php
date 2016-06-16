<?php 

namespace Lighty\Kernel\Atomium\Compiler;

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
		return AtomiumCompileOneLineInstruction::run($script, "@lang", ";", "<?php echo Translator::get(" ,"); ?>");
	}
}