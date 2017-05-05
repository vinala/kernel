<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileCSS
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@css', ';', '<?php Assets::css', '; ?>');
    }
}
