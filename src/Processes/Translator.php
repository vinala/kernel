<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Process\Exception\TranslatorFolderNeededException;
use Vinala\Kernel\Process\Exception\TranslatorManyFolderException;
use Vinala\Kernel\String\Strings;

/**
 * Language class.
 */
class Translator extends Process
{
    public static function create($name, $rt = null)
    {
        $root = is_null($rt) ? Process::root : $rt;
        //
        $file = self::replace($name);
        $folders = Strings::splite($file, '/');
        $folder = $folders[0];
        //
        $file = self::createFolders($folders, $root, $folder);
        //
        return self::createFile($file['file'], $file['path']);
    }

    public static function replace($name)
    {
        return str_replace('.', '/', $name);
    }

    protected static function createFolders($folders, $root, $folder)
    {
        $initPath = $path = $root.'resources/translator/';
        //
        if (count($folders) > 2) {
            throw new TranslatorManyFolderException();
        }
        //
        for ($i = 0; $i < count($folders) - 1; $i++) {
            $value = $folders[$i];
            //
            if (is_dir($path.$value)) {
                $path .= $value.'/';
            } else {
                $path .= $value.'/';
                mkdir($path, 0777, true);
                //
                File::put("$path$folder.php", self::index($folder));
            }
        }
        $file = $folders[count($folders) - 1];
        //
        if ($path == $initPath) {
            throw new TranslatorFolderNeededException($file);
        }
        //
        return ['path' => $path, 'file' => $file];
    }

    public static function createFile($file, $path)
    {
        if (!File::exists("$path$file.php")) {
            File::put("$path$file.php", self::set($file));

            return true;
        } else {
            return false;
        }
    }

    public static function set($file)
    {
        $txt = "<?php\n\n";
        $txt .= "/**\n* $file translator\n*\n";
        $txt .= self::track();
        $txt .= "**/\n\n";
        $txt .= 'return'." [\n\t// 'key' => 'value',\n];";

        return $txt;
    }

    /**
     * Create index language file.
     *
     * @param string $lang
     *
     * @return string
     */
    protected static function index($file)
    {
        $txt = "<?php\n\n";
        $txt .= "/**\n* The short key file for $file language\n*\n";
        $txt .= "**/\n\n";
        $txt .= 'return'." [\n\t// 'key' => 'value',\n];";

        return $txt;
    }

    /**
     *   Listing all schemas.
     */
    public static function ListAll()
    {
        $data = [];
        //
        $folders = glob(Application::$root.'resources/translator/*');
        //
        foreach ($folders as $key => $value) {
            $folder = \Strings::splite($value, 'resources/translator/');
            $folder = $folder[1];
            //
            $data[] = '>'.$folder;
            //
            foreach (glob(Application::$root.'resources/translator/'.$folder.'/*.php') as $key2 => $value2) {
                $file = \Strings::splite($value2, "app/lang/$folder/");
                $file = $file[1];
                //
                $data[] = '   '.$file;
            }
        }
        //
        return $data;
    }
}
