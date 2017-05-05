<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileForeach
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@foreach', ':', '<?php foreach ', ': ?>');
    }
}
