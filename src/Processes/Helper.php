<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Foundation\Application;

/**
 * Controller class.
 */
class Helper extends Process
{
    public static function create($name, $rt = null)
    {
        $Root = is_null($rt) ? Process::root : $rt;
        //

        $path = $Root."support/helpers/$name.php";

        if (!File::exists($path)) {
            File::put($path, self::set($name));

            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate helper code.
     *
     * @param string $name
     *
     * @return string
     */
    public static function set($name)
    {
        $txt = "<?php\n\n";
        $txt .= "if (!function_exists('$name')) {\n";
        $txt .= "\n\t/**\n\t * $name helper\n\t *\n\t * @param void\n\t *\n\t * @return void \n\t */\n";
        $txt .= "\tfunction $name()\n\t{\n\t\t// do something \n\t}";
        $txt .= "\n\n}";

        return $txt;
    }

    /**
     *   Listing all schemas.
     */
    public static function ListAll()
    {
        $controllers = glob(root().'support/helpers/*.php');
        //
        return $controllers;
    }

    /**
     * clear all controllers created.
     *
     * @return bool
     */
    public static function clear()
    {
        $files = File::glob(Application::$root.'support/helpers/*');
        //
        foreach ($files as $file) {
            File::delete($file);
        }
        //
        return true;
    }
}
