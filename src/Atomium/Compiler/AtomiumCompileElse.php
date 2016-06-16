<?php 

namespace Lighty\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileElse
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileOneLineInstruction::run($script, "@else", ":", "<?php else " ,": ?>");
	}
}