<?php 

namespace Vinala\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileIf
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileInstructions::run($script, "@if", ":", "<?php if " ," : ?>");
	}
}