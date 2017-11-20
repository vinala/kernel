<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Filesystem\File;

/**
 * Query Processor.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Query extends Process
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

        $path = static::folder($root);

        $path = $path."/$name.php";

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
        $txt .= "namespace App\Queries;\n\n";
        $txt .= "use Vinala\Kernel\Database\Query\Querying;\n\n";
        $txt .= self::docs("$name Querying");
        $txt .= "class $name extends Querying\n{\n\n";
        // $txt .= "\t/**\n\t * Create new querying instance\n";
        // $txt .= "\t *\n";
        // $txt .= "\t * @return void\n\t */\n";
        // $txt .= "\tpublic function __construct()\n\t{";
        // $txt .= "\n\t\t// ";
        // $txt .= "\n\t}\n\n";
        $txt .= "\t/**\n\t * Build the querying class\n";
        $txt .= "\t *\n";
        $txt .= "\t * @return \$this\n\t */\n";
        $txt .= "\tpublic function build()\n\t{";
        $txt .= "\n\t\t// do something";
        $txt .= "\n\t}\n\n}";

        return $txt;
    }

    /**
     * The Instante creation for mail folder.
     *
     * @return string
     */
    protected function folder($root)
    {
        $path = $root.'database/queries ';

        if (!File::isDirectory($path)) {
            File::makeDirectory($path);
        }

        return $path;
    }
}
