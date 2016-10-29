<?php 

namespace Vinala\Kernel\Atomium\Compiler;

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
		return AtomiumCompileInstructions::run($script, "@call", ";", "<?php echo \Vinala\Kernel\Atomium\Atomium::call" ,"; ?>");
	}
}