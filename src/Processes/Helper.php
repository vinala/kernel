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
        $txt = "<?php\n\n/**\n* $name helper\n*\n* @param //\n* @return // \n**/\n";
        $txt .= "function $name()\n{\n\t// do something \n}";

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
