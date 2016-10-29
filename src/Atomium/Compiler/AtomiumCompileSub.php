<?php 

namespace Vinala\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileSub
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileInstructions::run($script, "@sub", ";", "<?php View::make" ,"; ?>");
	}
}