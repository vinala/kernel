<?php 

namespace Vinala\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileBreak
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileInstructions::run($script, "@break", ";", "<?php break" ,"; ?>");
	}
}