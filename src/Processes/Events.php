<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Filesystem\File;

/**
 * Exception class.
 */
class Events extends Process
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
    public static function create($name)
    {
        $root = Process::root;

        $path = $root."app/events/$name.php";

        if (!File::exists($path)) {
            File::put($path, self::set($name));

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
    protected static function set($name)
    {
        $txt = "<?php\n\n";
        $txt .= "namespace Vinala\App\Events;\n\n";
        $txt .= "use Vinala\Kernel\Events\EventListener as Listener;\n\n";
        $txt .= self::docs("$name Event");
        $txt .= "class $name extends Listener\n{\n\n";
        $txt .= self::eventArray();
        $txt .= self::eventFunction();
        $txt .= '}';

        return $txt;
    }

    /**
     * Generate events array.
     *
     * @return string
     */
    protected static function eventArray()
    {
        $txt = "\t/**\n\t* Set events pattern and thier function\n\t*\n\t* @var array\n\t*/\n\t";

        $txt .= 'protected static $events = ['."\n\t\t'someEvent' => 'onSomeEvent',\n\t];\n\n\n\n";

        return $txt;
    }

    /**
     * Generate events function.
     *
     * @return string
     */
    protected static function eventFunction()
    {
        $txt = "\t/**\n\t* Event function\n\t*/\n\t";

        $txt .= 'public function onSomeEvent()'."\n\t{\n\t\t// do something \n\t}\n\n";

        return $txt;
    }
}
