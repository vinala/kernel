<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileElse
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@else', ':', '<?php else ', ': ?>');
    }
}
