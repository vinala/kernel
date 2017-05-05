<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileEndFor
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@endfor', ';', '<?php endfor ', '; ?>');
    }
}
