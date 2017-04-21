<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Process\Process;
use Vinala\Kernel\Objects\DateTime as Time;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Filesystem\File;

/**
* Link class
*/
class Links extends Process
{
    public static function create($name, $rt = null)
    {
        $time = Time::now();
        if (empty($name)) {
            $name=$time;
        }
        //
        $Root = is_null($rt) ? Process::root : $rt ;

        $path = $Root.'resources/links/'.$name.'.php';
        
        if (! File::exists($path)) {
            File::put($path, self::set($name));
            //
            return true;
        } else {
            return false;
        }
    }

    public static function set($name)
    {
        $txt = "<?php\n\n";
        $txt .= "/**\n* $name linker\n*\n";

        $txt .= self::track();

        $txt .= "* @var array \n";
        $txt .= "**/\n\n";
        $txt .= 'return'." [\n\t// 'key' => 'value',\n];";

        return $txt;
    }

    /**
    *   Listing all schemas
    */
    public static function ListAll()
    {
        $links = glob(root()."resources/links/*.php");
        //
        return $links;
    }
}
