<?php 

namespace Lighty\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileTake
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileOneLineInstruction::run($script, "@call", ";", "<?php \Lighty\Kernel\Atomium\Atomium::call(" ,"); ?>");
	}
}