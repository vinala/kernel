<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileEndUntil
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@enduntil', ';', '<?php endwhile', '; ?>');
    }
}
