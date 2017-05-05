<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Foundation\Application;

/**
 * Controller class.
 */
class Tests extends Process
{
    public static function create($name, $rt = null)
    {
        $Root = is_null($rt) ? Process::root : $rt;
        //
        $path = $Root."tests/$name.test.php";

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
        $txt = "<?php\n\nuse Vinala\Kernel\Testing\TestCase as BaseTestCase;\n";

        $txt .= self::docs("$name test case");
        $txt .= 'class '.$name."Test extends BaseTestCase \n{\n";
        $txt .= "\t/*\n\t* Add functions for test with the argument @test \n\t* in function docblock to mention that the function\n\t* will used for test\n\t**/";
        $txt .= "\n}";

        return $txt;
    }

    /**
     *   Listing all schemas.
     */
    public static function ListAll()
    {
        $controllers = glob(root().'tests/*.test.php');
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
        $files = File::glob(Application::$root.'tests/*.test.php');
        //
        foreach ($files as $file) {
            File::delete($file);
        }
        //
        return true;
    }
}
