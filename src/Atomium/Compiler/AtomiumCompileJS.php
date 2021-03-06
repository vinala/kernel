<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileJS
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@js', ';', '<?php Assets::js', '; ?>');
    }
}
