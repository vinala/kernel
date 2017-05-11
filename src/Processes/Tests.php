<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\String\Strings;

/**
 * Controller class.
 */
class Tests extends Process
{
    public static function create($name, $rt = null)
    {
        $Root = is_null($rt) ? Process::root : $rt;
        //

        $folders = Strings::splite($name, '.');
        $file = static::createFolders($folders, $Root);
        
        $path =  $file['path'].$file['file'].".test.php";

        if (!File::exists($path)) {
            File::put($path, self::set($file['file']));

            return ['process' => true , 'path' => $path];
        } else {
            return ['process' => false , 'path' => ''];
        }
    }

    /**
    * Create a test folder
    *
    * @param string $folder
    * @param string $root
    * @return string
    */
    private static function createFolders($folders, $root)
    {
        $path = $root.'tests/';
        //
        for ($i = 0; $i < count($folders) - 1; $i++) {
            $value = $folders[$i];
            //
            if (is_dir($path.$value)) {
                $path .= $value.'/';
            } else {
                $path .= $value.'/';
                mkdir($path, 0777, true);
            }
        }
        //
        return ['path' => $path, 'file' => $folders[count($folders) - 1]];
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
