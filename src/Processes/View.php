<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\String\Strings;
use Vinala\Kernel\Time\DateTime as Time;

/**
 * View class.
 */
class View extends Process
{
    protected static function replace($name)
    {
        return str_replace('.', '/', $name);
    }

    protected static function createFolders($folders, $root)
    {
        $path = $root.'resources/views/';
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

    public static function create($name, $template, $rt = null)
    {
        switch ($template) {
            case 'smarty':
                $extention = '.tpl.php';
                break;
            case 'atom':
                $extention = '.atom';
                break;
            default:
                $extention = '.php';
                break;
        }
        //
        $Root = is_null($rt) ? Process::root : $rt;
        $file = self::replace($name);
        $folders = Strings::splite($file, '/');
        //
        $file = self::createFolders($folders, $Root);
        //
        return self::CreatView($file['file'], $file['path'], $extention);
    }

    protected static function CreatView($file, $path, $ext)
    {
        if (!file_exists($path."$file$ext")) {
            $myfile = fopen($path."$file$ext", 'w');
            //
            $txt = self::set($ext, $file, $path);
            //
            fwrite($myfile, $txt);
            fclose($myfile);
            //
            return 1;
        } else {
            return 2;
        }
    }

    protected static function set($ext, $file, $path)
    {
        $path = Strings::replace($path, '/', '.');
        $strings = Strings::splite($path, 'resources.views.');
        $path = $strings[1].$file;
        //
        if ($ext == '.atom' || $ext == '.tpl.php') {
            $result = "{//\n\t@file $file\n\t@path $path";

            if (Config('lumos.tracking')) {
                $result .= "\n\t@autor ".config('app.owner')."\n\t@time ".Time::now()." ('".time()."')";
            }

            $result .= "\n//}\n\n";
        } else {
            $result = "<?php\n/*\n\t@file $file\n\t@path $path";

            if (Config('lumos.tracking')) {
                $result .= "\n\t@autor ".config('app.owner')."\n\t@time ".Time::now()." ('".time()."')";
            }

            $result .= "\n**/\n?>\n";
        }

        return $result;
    }
}
