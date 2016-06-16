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
		return AtomiumCompileInstructions::run($script, "@call", ";", "<?php echo \Lighty\Kernel\Atomium\Atomium::call" ,"; ?>");
	}
}