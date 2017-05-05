<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileWhile
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@while', ':', '<?php while ', ': ?>');
    }
}
