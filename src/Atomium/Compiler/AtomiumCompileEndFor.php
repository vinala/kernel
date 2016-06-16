<?php 

namespace Lighty\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileEndFor
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileOneLineInstruction::run($script, "@endfor", ";", "<?php endfor " ,"; ?>");
	}
}