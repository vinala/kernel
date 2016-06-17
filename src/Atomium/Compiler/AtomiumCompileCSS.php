<?php 

namespace Lighty\Kernel\Atomium\Compiler;

/**
* 
*/
class AtomiumCompileCSS
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileInstructions::run($script, "@css", ";", "<?php Libs::css" ,"; ?>");
		// Libs::css("app/resources/library/bootstrap-3.3.1.min.css",false);
	}
}