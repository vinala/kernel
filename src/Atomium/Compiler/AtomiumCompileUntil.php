<?php

namespace Vinala\Kernel\Atomium\Compiler;

class AtomiumCompileUntil
{
    /**
     * run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        return AtomiumCompileInstructions::run($script, '@until', ':', '<?php while ( ! ', ' ) : ?>');
    }
}
