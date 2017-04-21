<?php

namespace Vinala\Kernel\Process ;

//use SomeClass;

/**
* Alias process class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Process
* @since v3.3.0
*/
class Alias extends Process
{

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * Get documentation of config file
    *
    * @return array
    */
    protected static function documentations()
    {
        return [
            'enabled' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Enable Aliases\n\t|----------------------------------------------------------\n\t| Here to activate classes aliases\n\t|\n\t**/\n",

            'kernel' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Kernel Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of class\n\t| in the kernel.\n\t|\n\t**/\n",

            'user' => "\n\t/*\n\t|----------------------------------------------------------\n\t| User Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for your aliases, feel\n\t| free to register as many as \n\t| you wish as the aliases are 'lazy' loaded so \n\t| they don't hinder performance.\n\t|\n\t**/\n",

            'exceptions' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Exceptions Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of exceptions class\n\t| classes\n\t|\n\t**/\n",

            'controllers' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Controllers Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of controllers class\n\t| classes\n\t|\n\t**/\n",

            'models' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Models Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of models class\n\t| classes\n\t|\n\t**/\n",
        ];
    }

    /**
    * Set the config params
    *
    * @param bool $enabled
    * @param array $params
    * @return bool
    */
    public static function set($enabled, $params)
    {

        $docs = self::documentations();
        $content = $docs['enabled'].self::enbaledFormat($enabled);
        $content .= $docs['kernel'].self::arrayFormat($params['kernel'], 'kernel');
        $content .= $docs['exceptions'].self::arrayFormat($params['exceptions'], 'exceptions');
        $content .= $docs['controllers'].self::arrayFormat($params['controllers'], 'controllers');
        $content .= $docs['models'].self::arrayFormat($params['models'], 'models');

        $content = self::fileFormat($content);

        // d($content);

        return self::setFile($content);
    }

    /**
    * Set the file
    *
    * @param
    * @param
    * @return
    */
    protected static function setFile($content)
    {
        $root = Process::root;

        if (file_exists(Process::root.'config/alias.php')) {
            $file = fopen(Process::root.'config/alias.php', "w");
            fwrite($file, $content);
            fclose($file);
            //
            return true;
        }
        
        return false;
    }
    

    /**
    * Enabled switch format
    *
    * @param bool $enabled
    * @return string
    */
    protected static function enbaledFormat($enabled)
    {
        return "\t'enable' => ".($enabled ? 'true' : 'false')." ,\n\n";
    }

    /**
    * Format args array
    *
    * @param array $data
    * @param string $name
    * @return string
    */
    protected static function arrayFormat(array $data, $name)
    {
        $format = "\t'$name' => [\n";

        foreach ($data as $key => $value) {
            $format .= "\t\t'$key' => $value::class , \n";
        }

        $format .= "\t],\n\n";

        return $format;
    }

    /**
    * Format the alias config file
    *
    * @param string $content
    * @return bool
    */
    protected static function fileFormat($content)
    {
        $container = "<?php\n\nreturn [\n";

        $container .= $content;

        $container .= "];";

        return $container;
    }
}
