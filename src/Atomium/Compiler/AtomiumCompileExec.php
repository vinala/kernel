<?php 

namespace Lighty\Kernel\Atomium\Compiler;


class AtomiumCompileExec
{
	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		return AtomiumCompileInstruction::openTag($script, "{{{", "<?php ", "}}}", " ?> ");
	}
}