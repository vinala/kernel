<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Config\Alias;
use Vinala\Kernel\Filesystem\File;

/**
 * Exception class.
 */
class Exception extends Process
{
    /**
     * Create exception.
     *
     * @param string $name
     * @param string $message
     * @param string $view
     *
     * @return bool
     */
    public static function create($name, $message, $view)
    {
        $root = Process::root;
        $name = ucfirst($name);
        $path = $root."app/exceptions/$name.php";
        //

        if (!File::exists($path)) {
            File::put($path, self::set($name, $message, $view));

            return true;
        } else {
            return false;
        }
    }

    /**
     * Build the class script.
     *
     * @param string $name
     * @param string $message
     * @param string $view
     *
     * @return string
     */
    protected static function set($name, $message, $view)
    {
        $txt = "<?php\n\n";
        $txt .= "namespace App\Exception;\n\n";
        $txt .= "use Vinala\Kernel\Logging\Exception;\n\n";
        $txt .= self::docs("$name Exception");
        $txt .= "class $name extends Exception\n{\n\n";
        $txt .= "\t/**\n\t* The exception constructor\n\t*\n\t*/\n";
        $txt .= "\tfunction __construct()\n\t{\n";
        $txt .= "\t\t/**\n\t\t* The exception message\n\t\t*\n\t\t* @param string\n\t\t*/";
        $txt .= "\n\t\t".'$this->message = '."'$message';";
        $txt .= "\n\n\t\t/**\n\t\t* The exception view if debugging mode activated\n\t\t*\n\t\t* @param string\n\t\t*/";
        $txt .= "\n\t\t".'$this->view = '."'$view';";
        $txt .= "\n\t}\n}";

        return $txt;
    }

    /**
     * clear all controllers created.
     *
     * @return bool
     */
    public static function clear()
    {
        $path = root().'app/exceptions/*.php';

        $files = File::glob($path);
        //
        foreach ($files as $file) {
            File::delete($file);
        }
        //
        Alias::clear('exceptions');
        //
        return true;
    }
}
