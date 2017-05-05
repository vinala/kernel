<?php

namespace Vinala\Kernel\Process;


use Vinala\Kernel\Filesystem\File;

/**
 * Controller class.
 */
class Tag extends Process
{
    public static function create($class, $target, $tag, $write = false)
    {
        $Root = Process::root;
        $path = $Root."resources/tags/$class.php";

        if (!File::exists($path)) {
            File::put($path, self::set($class, $target, $tag, $write));
            //
            return true;
        }
    }

    protected static function set($class, $target, $tag, $write = false)
    {
        $txt = "<?php\n\nnamespace App\View\Atomium\UserTag;\n\nuse Vinala\Kernel\Atomium\UserCompiler\AtomiumUserTags;\n\n";

        $txt .= self::docs("$class Atomium tag");
        $txt .= "\n\nclass $class extends AtomiumUserTags\n{\n\t";

        $txt .= "\n\t/**\n\t * The function that Atomium should replace it.\n\t *\n\t * @var string\n\t */\n\tprotected static ".'$target = '.'"'.$target.'"'.";\n\n";
        $txt .= "\n\t/**\n\t * The tag that Atomium should replace it by the function (without @).\n\t *\n\t * @var string\n\t */\n\tprotected static ".'$tag = '.'"'.$tag.'"'.";\n\n";

        $write = $write ? 'true' : 'false';
        $txt .= "\n\t/**\n\t * If set true Atomium will echo the returned value from the function.\n\t *\n\t * @var bool\n\t */\n\tprotected static ".'$hold = '.$write.";\n\n";

        $txt .= "\n}";

        return $txt;
    }

    /**
     *   Listing all schemas.
     */
    public static function ListAll()
    {
        $path = root().'resources/tags/*.php';

        return glob($path);
    }
}
