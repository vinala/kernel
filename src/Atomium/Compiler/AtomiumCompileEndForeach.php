<?php 

namespace Vinala\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileEndForeach
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileInstructions::run($script, "@endforeach", ";", "<?php endforeach " ,"; ?>");
	}
}