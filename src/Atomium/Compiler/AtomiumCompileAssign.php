<?php 

namespace Lighty\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileAssign
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileInstructions::run($script, "@assign", ";", "<?php " ,"; ?>");
	}
}