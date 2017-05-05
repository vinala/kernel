<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileEndIf
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@endif', ';', '<?php endif ', '; ?>');
    }
}
