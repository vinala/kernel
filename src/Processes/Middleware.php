<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Filesystem\File;

/**
 * Documentation.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Middleware extends Process
{
    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Function to create Middleware.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function create($name)
    {
        $root = Process::root;

        $path = $root."app/http/middleware/$name.php";

        if (!File::exists($path)) {
            File::put($path, self::set($name));

            return true;
        }

        return false;
    }

    /**
     * Build the middleware script.
     *
     * @param string $name
     *
     * @return string
     */
    protected static function set($name)
    {
        $txt = "<?php\n\n";
        $txt .= "namespace App\Http\Middleware;\n\n";
        $txt .= "use Vinala\Kernel\Http\Request;\n\n";
        $txt .= self::docs("$name Middleware");
        $txt .= "class $name\n{\n\n";
        $txt .= "\t/**\n\t* Handle the middleware\n";
        $txt .= "\t*\n\t* @param Vinala\Kernel\Http\Request \$req\n";
        $txt .= "\t* @return bool|string\n\t**/\n";
        $txt .= "\tpublic function handle(Request \$req)\n\t{";
        $txt .= "\n\t\t// do something";
        $txt .= "\n\t}\n\n}";

        return $txt;
    }
}
